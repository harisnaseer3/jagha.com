<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Throwable;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request, $property)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        try {
            $host = '';
            if ($request->filled('video_host')) $host = $request->input('video_host');
            else  $host = ucfirst(explode('.', $request->input('video_link'))[1]);
            $required_host = array('youtube', 'dailymotion', 'vimeo');

            if (in_array(lcfirst($host), $required_host)) {
                $video = (new Video)->updateOrCreate(['name' => $request->input('video_link'), 'host' => $host], [
                    'user_id' => $user_id,
                    'property_id' => $property->id,
                    'name' => $request->input('video_link'),
                    'host' => $host
                ]);
            } else
                return redirect()->back()->withInput()->with('error', 'Video is not added, select a host listed below');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $property)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $host = '';
        if ($request->filled('video_host')) $host = $request->input('video_host');
        else  $host = ucfirst(explode('.', $request->input('video_link'))[1]);
        try {
            $video = (new Video)->updateOrCreate(['name' => $request->input('video_link'), 'host' => $host], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'name' => $request->input('video_link'),
                'host' => $host
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not updated, try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Video $video
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $video = (new Video)->find($request->input('image-record-id'));

        if ($video->exists) {
            try {
                $video->delete();
                return redirect()->back()->with('success', 'Video deleted successfully');

            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Video not found');
            }
        }
        return redirect()->back()->with('error', 'Video not found');
    }
}
