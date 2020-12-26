<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AddWaterMark implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image_str = explode('.webp', $this->image->name)[0];
        foreach (['-750x600.webp', '-450x350.webp', '-200x200.webp'] as $size) {
            $image_name = $image_str . $size;
//            dd($image_name);
            $thumbnailpath = ('thumbnails/properties/' . $image_name);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath);

            // water mark code
            $watermark = \Intervention\Image\Facades\Image::make('img/watermark.png');
            $resizePercentage = 70;//70% less then an actual image (play with this value)
            $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2); //watermark will be $resizePercentage less then the actual width of the image

            // resize watermark width keep height auto
            $watermark->resize($watermarkSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->opacity(40);

            $img->insert($watermark, 'center');

            $img->save($thumbnailpath);
            echo('done');

        }
        $this->image->watermarked = 1;
        $this->image->save();
    }

}

