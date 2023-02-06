<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
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
        // $user = Auth::user();
        
        $users = User::all();

        $projects = Project::all();

        return view("admin.index", compact('users', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "CREA NUOVO PROGETTO";

        return view("admin.create", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // validated() usa le regole indicate nella funzione rules dello StorePostRequest e ci ritorna i dati validati
        $data = $request->validated();
        
        // $data = $request->all();

        // Salviamo il file nello storage e recuperiamo il path
        // $path = Storage::put("posts", $data["cover_img"]);

        // carico il file solo se ne ricevo uno
        if (key_exists("cover_img", $data)) {
            // salvo in una variabile temporanea il percorso del nuovo file
            $path = Storage::put("posts", $data["cover_img"]);
        }

        $project = Project::create($data);
        $project->cover_img = $path;
        $project->save();

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // $project = Project::findOrFail($id);

        return view('admin.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // $project = Project::findOrFail($id);

        return view('admin.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // validated() usa le regole indicate nella funzione rules dell'UpdatePostRequest e ci ritorna i dati validati
        $data = $request->validated();

        // $data = $request->all();

        // $project = Project::findOrFail($id);
        $project->update($data);

        // carico il file solo se ne ricevo uno
        if (key_exists("cover_img", $data)) {
            // salvo in una variabile temporanea il percorso del nuovo file
            $path = Storage::put("posts", $data["cover_img"]);
            // Dopo aver caricato la nuova immagine, prima di aggiornare il db,
            // cancelliamo dallo storage il vecchio file.
            Storage::delete($project->cover_img);

            $project->cover_img = $path;
        }

        $project->save();

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
    
        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }
    
        $project->delete();

        return redirect()->route("projects.index");
    }
}
