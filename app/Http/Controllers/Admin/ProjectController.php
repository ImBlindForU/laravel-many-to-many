<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create',compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Project::generateSlug($validated['title']);

        if($request->hasFile('cover_image')){
            $path = Storage::put('project_images', $request->cover_image);
            $validated['cover_image']= $path;
        }
        $project = Project::create($validated);

        if($request->has('technologies')){
            $project->technologies()->attach($request->technologies);
        }
        return redirect()->route('admin.project.index')->with('message','il project e stato creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.show', compact('project','types','technologies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->all();
        $validated['slug'] = Project::generateSlug($validated['title']);

        if($request->hasFile('cover_image')){
            if($project->cover_image){
                Storage::delete($project->cover_image);
            }
            $path= Storage::put('project_images', $request->cover_image);
            $validated['cover_image']= $path;
        }

        $project->update($validated);

        if($request->has('technologies')){
            $project->technologies()->sync($request->technologies);
        } else{
            $project->technologies()->sync([]);

        }

        return redirect()->route('admin.project.index')->with('message'," $project->title e stato modificato correttamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.project.index')->with('message', "$project->title e stato cancellato");
    }
}
 