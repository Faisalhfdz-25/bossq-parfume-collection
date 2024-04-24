<?php

namespace App\Http\Controllers;

use App\Models\LandingPages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPagesController extends Controller
{
    public function index()
    {
        $landingPages = LandingPages::all();
        return view('pages.landing_pages.index', compact('landingPages'));
    }
    public function welcome()
    {
    $landingPage = LandingPages::first(); 
    return view('welcome', compact('landingPage'));
    }


    public function create()
    {
        return view('pages.landing_pages.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/webm|max:20480', // 20 MB
            'single_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|numeric',
            'content' => 'required|string',
        ]);

        $landingPage = new LandingPages();
        $landingPage->title = $validatedData['title'];
        $landingPage->product_price = $validatedData['product_price'];
        $landingPage->content = $validatedData['content'];

        // Upload banner image
        $bannerImageName = Str::random(20) . '.' . $request->file('banner_image')->getClientOriginalExtension();
        $request->file('banner_image')->storeAs('public/landing_page_images', $bannerImageName);
        $landingPage->banner_image_url = $bannerImageName;

        // Upload Instagram photo
        if ($request->hasFile('instagram_photo')) {
            $instagramPhotoName = Str::random(20) . '.' . $request->file('instagram_photo')->getClientOriginalExtension();
            $request->file('instagram_photo')->storeAs('public/landing_page_images', $instagramPhotoName);
            $landingPage->instagram_photo_url = $instagramPhotoName;
        }

        // Upload video
        if ($request->hasFile('video')) {
            $videoName = Str::random(20) . '.' . $request->file('video')->getClientOriginalExtension();
            $request->file('video')->storeAs('public/landing_page_videos', $videoName);
            $landingPage->video_url = $videoName;
        }

        // Upload single photo
        $singlePhotoName = Str::random(20) . '.' . $request->file('single_photo')->getClientOriginalExtension();
        $request->file('single_photo')->storeAs('public/landing_page_images', $singlePhotoName);
        $landingPage->single_photo_url = $singlePhotoName;

        $landingPage->save();

        return redirect()->route('landing_pages.index')->with('success', 'Landing Page Component Added Successfully');
    }

    // Metode untuk menampilkan form edit
    public function edit($id)
    {
        $landingPage = LandingPages::findOrFail($id);
        return view('pages.landing_pages.edit', compact('landingPage'));
    }

    // Metode untuk menyimpan perubahan data
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/webm|max:20480', // 20 MB
            'single_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|numeric',
            'content' => 'required|string',
        ]);

        $landingPage = LandingPages::findOrFail($id);
        $landingPage->title = $validatedData['title'];
        $landingPage->product_price = $validatedData['product_price'];
        $landingPage->content = $validatedData['content'];

        // Upload banner image jika ada
        if ($request->hasFile('banner_image')) {
            $bannerImageName = Str::random(20) . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $request->file('banner_image')->storeAs('public/landing_page_images', $bannerImageName);
            $landingPage->banner_image_url = $bannerImageName;
        }

        // Upload Instagram photo jika ada
        if ($request->hasFile('instagram_photo')) {
            $instagramPhotoName = Str::random(20) . '.' . $request->file('instagram_photo')->getClientOriginalExtension();
            $request->file('instagram_photo')->storeAs('public/landing_page_images', $instagramPhotoName);
            $landingPage->instagram_photo_url = $instagramPhotoName;
        }

        // Upload video jika ada
        if ($request->hasFile('video')) {
            $videoName = Str::random(20) . '.' . $request->file('video')->getClientOriginalExtension();
            $request->file('video')->storeAs('public/landing_page_videos', $videoName);
            $landingPage->video_url = $videoName;
        }

        // Upload single photo jika ada
        if ($request->hasFile('single_photo')) {
            $singlePhotoName = Str::random(20) . '.' . $request->file('single_photo')->getClientOriginalExtension();
            $request->file('single_photo')->storeAs('public/landing_page_images', $singlePhotoName);
            $landingPage->single_photo_url = $singlePhotoName;
        }

        $landingPage->save();

        return redirect()->route('landing_pages.index')->with('success', 'Landing Page updated successfully');
    }

    public function destroy($id)
    {
        $landingPage = LandingPages::findOrFail($id);
        $landingPage->delete();

        return redirect()->route('landing_pages.index')->with('success', 'Landing Page deleted successfully');
    }
}
