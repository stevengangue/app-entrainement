<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user = auth()->user();
        
        // Supprimer l'ancien avatar
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();
        
        return response()->json([
            'success' => true,
            'path' => Storage::url($path)
        ]);
    }
    
    public function uploadExerciseImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'exercise_id' => 'required|exists:exercises,id'
        ]);
        
        $exercise = Exercise::find($request->exercise_id);
        
        if ($exercise->image_url) {
            $oldPath = str_replace('/storage', 'public', $exercise->image_url);
            Storage::delete($oldPath);
        }
        
        $path = $request->file('image')->store('exercises', 'public');
        $exercise->image_url = Storage::url($path);
        $exercise->save();
        
        return response()->json([
            'success' => true,
            'path' => Storage::url($path),
            'message' => 'Image téléchargée avec succès'
        ]);
    }
    
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi|max:102400', // 100MB max
            'exercise_id' => 'required|exists:exercises,id'
        ]);
        
        $path = $request->file('video')->store('videos', 'public');
        
        return response()->json([
            'success' => true,
            'path' => Storage::url($path),
            'message' => 'Vidéo téléchargée avec succès'
        ]);
    }
    
    public function deleteMedia(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $path = str_replace('/storage', 'public', $request->path);
        
        if (Storage::delete($path)) {
            return response()->json([
                'success' => true,
                'message' => 'Fichier supprimé avec succès'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression'
        ], 500);
    }
}