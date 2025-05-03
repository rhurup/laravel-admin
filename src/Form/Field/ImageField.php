<?php

namespace Rhurup\Admin\Form\Field;

use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as InterventionImage;
use Intervention\Image\ImageManagerStatic;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ImageField
{
    /**
     * Intervention calls.
     *
     * @var array
     */
    protected $interventionCalls = [];

    /**
     * Thumbnail settings.
     *
     * @var array
     */
    protected $thumbnails = [];

    /**
     * Default directory for file to upload.
     */
    public function defaultDirectory()
    {
        return config('admin.upload.directory.image');
    }

    /**
     * Execute Intervention calls.
     *
     * @param string $target
     */
    public function callInterventionMethods($target)
    {
        if (!empty($this->interventionCalls)) {
            $image = ImageManagerStatic::make($target);

            foreach ($this->interventionCalls as $call) {
                call_user_func_array(
                    [$image, $call['method']],
                    $call['arguments']
                )->save($target);
            }
        }

        return $target;
    }

    /**
     * Call intervention methods.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        if (static::hasMacro($method)) {
            return $this;
        }

        if (!class_exists(ImageManagerStatic::class)) {
            throw new \Exception('To use image handling and manipulation, please install [intervention/image] first.');
        }

        $this->interventionCalls[] = [
            'method' => $method,
            'arguments' => $arguments,
        ];

        return $this;
    }

    /**
     * Render a image form field.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->options(['allowedFileTypes' => ['image'], 'msgPlaceholder' => trans('admin.choose_image')]);

        return parent::render();
    }

    /**
     * @param string|array $name
     *
     * @return $this
     */
    public function thumbnail($name, ?int $width = null, ?int $height = null)
    {
        if (1 === func_num_args() && is_array($name)) {
            foreach ($name as $key => $size) {
                if (count($size) >= 2) {
                    $this->thumbnails[$key] = $size;
                }
            }
        } elseif (3 === func_num_args()) {
            $this->thumbnails[$name] = [$width, $height];
        }

        return $this;
    }

    /**
     * Destroy original thumbnail files.
     *
     * @return void
     */
    public function destroyThumbnail()
    {
        if ($this->retainable) {
            return;
        }

        foreach ($this->thumbnails as $name => $_) {
            /*  Refactoring actual remove lofic to another method destroyThumbnailFile()
            to make deleting thumbnails work with multiple as well as
            single image upload. */

            if (is_array($this->original)) {
                if (empty($this->original)) {
                    continue;
                }

                foreach ($this->original as $original) {
                    $this->destroyThumbnailFile($original, $name);
                }
            } else {
                $this->destroyThumbnailFile($this->original, $name);
            }
        }
    }

    /**
     * Remove thumbnail file from disk.
     *
     * @return void
     */
    public function destroyThumbnailFile($original, $name)
    {
        $ext = @pathinfo($original, PATHINFO_EXTENSION);

        // We remove extension from file name so we can append thumbnail type
        $path = @Str::replaceLast('.'.$ext, '', $original);

        // We merge original name + thumbnail name + extension
        $path = $path.'-'.$name.'.'.$ext;

        if ($this->storage->exists($path)) {
            $this->storage->delete($path);
        }
    }

    /**
     * Upload file and delete original thumbnail files.
     *
     * @return $this
     */
    protected function uploadAndDeleteOriginalThumbnail(UploadedFile $file)
    {
        foreach ($this->thumbnails as $name => $size) {
            // We need to get extension type ( .jpeg , .png ...)
            $ext = pathinfo($this->name, PATHINFO_EXTENSION);

            // We remove extension from file name so we can append thumbnail type
            $path = Str::replaceLast('.'.$ext, '', $this->name);

            // We merge original name + thumbnail name + extension
            $path = $path.'-'.$name.'.'.$ext;

            /** @var \Intervention\Image\Image $image */
            $image = InterventionImage::make($file);

            $action = $size[2] ?? 'resize';
            // Resize image with aspect ratio
            $image->$action($size[0], $size[1], function (Constraint $constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas($size[0], $size[1], 'center', false, '#ffffff');

            if (!is_null($this->storagePermission)) {
                $this->storage->put("{$this->getDirectory()}/{$path}", $image->encode(), $this->storagePermission);
            } else {
                $this->storage->put("{$this->getDirectory()}/{$path}", $image->encode());
            }
        }

        $this->destroyThumbnail();

        return $this;
    }
}
