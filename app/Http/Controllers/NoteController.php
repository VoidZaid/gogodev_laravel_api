<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Http\Requests\NoteRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\NoteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteController extends Controller
{
   public function index():JsonResource
   {
      // en apis retornamos Json, y en cruds monolitos devolvemos views
      // $notes = Note::all();
      // a continuacion la forma como se hace sin un NoteResourve
      // return response()->json(Note::all(), 200);
      // como se hace con un NoteResourve
      return NoteResource::Collection(Note::all());
   }
   // cuando el Request llega a nuestro controlador ya fue validado con NoteRequest, sino es correcta la validacion entonces NoteRequest manda atras la peticion
   public function store(NoteRequest $request):JsonResponse
   {
      $note = Note::create($request->all());
      return response()->json([
         'success' => true,
         'data'=>new NoteResource($note),
      ], 201);
   }
   public function show(string $id):JsonResource
   {
      $note = Note::find($id);
      // return response()->json($note, 200);
      return new NoteResource($note);
   }

   public function update(NoteRequest $request, string $id):JsonResponse
   {
      $note = Note::find($id);
      $note->update($request->all());
      // $note->update([
      //    'title' => $request->title,
      //    'description' => $request->description,
      // ]);
      return response()->json([
         // 'message' => 'nota actualizada exitosamente',
         'success' => true,
         'data' => new NoteResource($note),
      ], 200);
   }

   public function destroy(string $id):JsonResponse
   {
      $note = Note::find($id)->delete();
      return response()->json([
         'message' => 'nota eliminada',
         'success' => true,
      ], 200);
   }
}
