<?php

namespace App\Livewire\Admin;

use App\Models\DisplayVideo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DisplayVideoManager extends Component
{
    use WithFileUploads;

    public $video;

    public function mount()
    {
        abort_unless(
            auth()->user()?->hasRole('Administrador'),
            403
        );
    }

    public function guardarVideo()
    {
        $this->validate([
            'video' => [
                'required',
                'file',
                'mimes:mp4',
                'max:512000',
            ],
        ], [
            'video.required' => 'Debes seleccionar un video.',
            'video.file' => 'El archivo seleccionado no es válido.',
            'video.mimes' => 'El video debe estar en formato MP4.',
            'video.max' => 'El video no puede superar los 500 MB.',
        ]);

        // Buscar el video actualmente activo
        $videoActual = DisplayVideo::where('activo', true)->first();

        // Generar un nombre único
        $nombreArchivo = 'display_' . now()->format('Ymd_His') . '.mp4';

        // Guardar primero el nuevo archivo
        $rutaNueva = $this->video->storeAs(
            'display',
            $nombreArchivo,
            'public'
        );

        // Si había un video anterior, eliminarlo
        if ($videoActual) {

            if (
                $videoActual->archivo &&
                Storage::disk('public')->exists($videoActual->archivo)
            ) {
                Storage::disk('public')->delete($videoActual->archivo);
            }

            $videoActual->update([
                'nombre' => $this->video->getClientOriginalName(),
                'archivo' => $rutaNueva,
                'activo' => true,
            ]);

        } else {

            DisplayVideo::create([
                'nombre' => $this->video->getClientOriginalName(),
                'archivo' => $rutaNueva,
                'activo' => true,
            ]);
        }

        // Limpiar el campo
        $this->reset('video');

        session()->flash(
            'mensaje',
            'El video del Display se actualizó correctamente.'
        );
    }

    public function eliminarVideo()
    {
        $videoActual = DisplayVideo::where('activo', true)->first();

        if (!$videoActual) {
            return;
        }

        if (
            $videoActual->archivo &&
            Storage::disk('public')->exists($videoActual->archivo)
        ) {
            Storage::disk('public')->delete($videoActual->archivo);
        }

        $videoActual->delete();

        session()->flash(
            'mensaje',
            'El video del Display fue eliminado correctamente.'
        );
    }

    public function render()
    {
        return view('livewire.admin.display-video-manager', [
            'videoActual' => DisplayVideo::where('activo', true)->first(),
        ]);
    }
}