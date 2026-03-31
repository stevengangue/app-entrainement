<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::with('category')->paginate(15);
        return view('admin.exercises.index', compact('exercises'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $muscleGroups = [
            'Pectoraux', 'Dos', 'Épaules', 'Biceps', 'Triceps', 
            'Quadriceps', 'Ischio-jambiers', 'Mollets', 'Abdominaux', 'Cardio'
        ];
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        
        return view('admin.exercises.create', compact('categories', 'muscleGroups', 'difficultyLevels'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'muscle_group' => 'required|string',
            'difficulty_level' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('exercises', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        
        Exercise::create($validated);
        
        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice créé avec succès !');
    }
    
    public function edit(Exercise $exercise)
    {
        $categories = Category::all();
        $muscleGroups = [
            'Pectoraux', 'Dos', 'Épaules', 'Biceps', 'Triceps', 
            'Quadriceps', 'Ischio-jambiers', 'Mollets', 'Abdominaux', 'Cardio'
        ];
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        
        return view('admin.exercises.edit', compact('exercise', 'categories', 'muscleGroups', 'difficultyLevels'));
    }
    
    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,' . $exercise->id,
            'description' => 'required|string',
            'instructions' => 'required|string',
            'muscle_group' => 'required|string',
            'difficulty_level' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($exercise->image_url) {
                $oldPath = str_replace('/storage', 'public', $exercise->image_url);
                Storage::delete($oldPath);
            }
            
            $path = $request->file('image')->store('exercises', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        
        $exercise->update($validated);
        
        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice mis à jour avec succès !');
    }
    
    public function destroy(Exercise $exercise)
    {
        if ($exercise->image_url) {
            $path = str_replace('/storage', 'public', $exercise->image_url);
            Storage::delete($path);
        }
        
        $exercise->delete();
        
        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice supprimé avec succès !');
    }
    
    public function library()
    {
        $exercises = Exercise::with('category')
            ->orderBy('name')
            ->paginate(20);
        
        $categories = Category::all();
        $muscleGroups = Exercise::distinct('muscle_group')->pluck('muscle_group');
        
        return view('exercises.library', compact('exercises', 'categories', 'muscleGroups'));
    }
}