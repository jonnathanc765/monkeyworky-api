<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBannerRequest;
use App\Models\Banner;
use App\Utils\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return Banner::all()->toJson();
    }

    public function store(CreateBannerRequest $request)
    {
        $date = new Carbon();
        $data = $request->validated();
        $this->check_availability($data['position']);
        $name = str_replace(' ', '-', $data['position']);
        $banner = Banner::create([
            'position' => $data['position'],
            'picture' => $request->file('picture')->storeAs("banners", "$name-$date->timestamp.png", 'public')
        ]);
        return $banner->toJson();
    }

    public function show(Request $request)
    {
        $banner = Banner::where('position', $request->position)->first();
        return $banner->toJson();
    }

    protected function check_availability($position = Banner::MAIN)
    {
        if (Banner::count() >= Banner::MAX_PER_POSITION[Banner::MAIN]) {
            $this->pop_banner($position);
        }
    }

    protected function pop_banner($position = Banner::MAIN)
    {
        $banner = Banner::where('position', $position)->first();
        $this->deleteImage($banner->picture);
        $banner->delete();
    }
}
