<?php

namespace App\ProteCMS\Core\Models\Animals;

use App\ProteCMS\Core\Models\BaseModel;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'animals_media';
    protected $touches = ['animal'];
    protected $fillable = ['animal_id', 'type', 'file', 'thumbnail', 'url', 'main'];

    public function scopeMain($query)
    {
        return $query->orderBy('main', 'DESC');
    }

    public function getPhotoUrlAttribute()
    {
        if (! $this->file) {
            return;
        }

        return route('animals::photo', ['id' => $this->animal_id, 'photo' => $this->file]);
    }

    public function getPhotoPathAttribute()
    {
        if (! $this->file) {
            return;
        }

        return Storage::disk()->getDriver()->getAdapter()->getPathPrefix().$this->getPath().'/'.$this->file;
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = null;

        if (Storage::exists($this->getPath().'/'.$this->getThumbnail())) {
            $thumbnail = $this->getThumbnail();
        } elseif (Storage::exists($this->getPath().'/'.$this->getThumbnail('m'))) {
            $thumbnail = $this->getThumbnail('m');
        }

        $file = $thumbnail ?: $this->file;

        return route('animals::photo', ['id' => $this->animal_id, 'photo' => $file]);
    }

    public function getThumbnailPathAttribute()
    {
        $thumbnail = null;

        if (Storage::exists($this->getPath().'/'.$this->getThumbnail())) {
            $thumbnail = $this->getThumbnail();
        } elseif (Storage::exists($this->getPath().'/'.$this->getThumbnail('m'))) {
            $thumbnail = $this->getThumbnail('m');
        }

        $file = $thumbnail ?: $this->file;

        return Storage::disk()->getDriver()->getAdapter()->getPathPrefix().$this->getPath().'/'.$file;
    }

    public function getMediumThumbnailPathAttribute()
    {
        $thumbnail = null;

        if (Storage::exists($this->getPath().'/'.$this->getThumbnail('m'))) {
            $thumbnail = $this->getThumbnail('m');
        }

        $file = $thumbnail ?: $this->file;

        return Storage::disk()->getDriver()->getAdapter()->getPathPrefix().$this->getPath().'/'.$file;
    }

    public function getMediumThumbnailUrlAttribute()
    {
        $thumbnail = null;

        if (Storage::exists($this->getPath().'/'.$this->getThumbnail('m'))) {
            $thumbnail = $this->getThumbnail('m');
        }

        $file = $thumbnail ?: $this->file;

        return route('animals::photo', ['id' => $this->animal_id, 'photo' => $file]);
    }

    public function getPath()
    {
        return 'web/'.app('App\ProteCMS\Core\Models\Webs\Web')->id.'/animals/'.$this->animal_id.'/photos';
    }

    public function getThumbnail($size = 'xs')
    {
        return 'thumbnail-'.$size.'-'.$this->file;
    }

    public function isMain()
    {
        return $this->main;
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
