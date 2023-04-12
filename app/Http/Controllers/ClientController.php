<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use Illuminate\Support\Facades\Validator;
use Auth;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;


#[Group("Clientes", "Rutas para el manejo de clientes")]
class ClientController extends Controller
{


  /**
   * Listar todos los clientes.
   */
  public function index()
  {
    $clients = Client::all();

    if (sizeof($clients) != 0) {

      $respuesta = APIHelpers::createAPIResponse(false, 200, 'Clientes encontrados', $clients);
      return $respuesta;
      // return $clients;
    } else {

      $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', 'No se encontraron clientes');
      return $respuesta;
    }
  }

  /**
   * Crear un nuevo cliente.
   ** @param  \Illuminate\Http\Request  $request
   */
  public function create(Request $request)
  {
    $rules = [
      // | unique:App\Models\Client, dni
      'dni' => 'numeric | required',
      'name' => 'string | required',
      'last_name' => 'string | required',
      'sex' => 'string | required',
      'address' => 'string | required',
      'phone' => 'numeric | required',
      'mail' => 'string | required',
      // 'enabled' => 'boolean | required',
      'enabled' => 'required',
    ];

    $messages = [
      'dni.numeric' => 'El DNI debe ser un número',
      'dni.required' => 'El DNI es requerido',
      'name.string' => 'El nombre debe ser una cadena de texto',
      'name.required' => 'El nombre es requerido',
      'last_name.string' => 'El apellido debe ser una cadena de texto',
      'last_name.required' => 'El apellido es requerido',
      'sex.string' => 'El sexo debe ser una cadena de texto',
      'sex.required' => 'El sexo es requerido',
      'address.string' => 'La dirección debe ser una cadena de texto',
      'address.required' => 'La dirección es requerida',
      'phone.numeric' => 'El teléfono debe ser un número',
      'phone.required' => 'El teléfono es requerido',
      'mail.string' => 'El mail debe ser una cadena de texto',
      'mail.required' => 'El mail es requerido',
      'enabled.boolean' => 'La habilitación debe ser true o false',
      'enabled.required' => 'La habilitación es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      // $estado = 5;
      // return response()->json([$validator->errors()]);

      $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

      return response()->json($respuesta, 200);
    }

    $client = new Client();

    $client->dni = $request->dni;
    $client->name = $request->name;
    $client->last_name = $request->last_name;
    $client->sex = $request->sex;
    $client->address = $request->address;
    $client->phone = $request->phone;
    $client->mail = $request->mail;
    $client->enabled = $request->enabled;

    if ($client->save()) {
      $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente generado con éxito', $client);
      return $respuesta;
    } else {
      $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', 'No se pudo generar el cliente');
      return $respuesta;
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Mostrar datos del cliente
   */
  public function show($id)
  {
    $client = Client::find($id);

    if ($client) {
      $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente encontrado con éxito', $client);
      return $respuesta;
    } else {
      $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontró el cliente', 'No se encontró el cliente');
      return $respuesta;
    }
  }

  /**
   * 
   * Modificar un cliente.
   * @param  \Illuminate\Http\Request  $request
   */

  #[UrlParam("id", "integer", "El ID del cliente.", required: true, example: "1")]
  #[BodyParam("name", "string", "El nombre del cliente.", required: true, example: "Juan")]
  #[BodyParam("last_name", "string", "El apellido del cliente.", required: true, example: "Perez")]
  #[BodyParam("sex", "string", "El sexo del cliente.", required: true, example: "M")]
  #[BodyParam("address", "string", "La dirección del cliente.", required: true, example: "Belgrano 123")]
  #[BodyParam("phone", "numeric", "El teléfono del cliente.", required: true, example: "3843407142")]
  #[BodyParam("mail", "string", "El mail del cliente.", required: true, example: "jp@gmail.com")]
  #[BodyParam("enabled", "boolean", "Indica si el cliente está o no disponible.", required: true, example: "true")]
  public function edit(Request $request)
  {
    $rules = [
      // | unique:App\Models\Client, dni
      // 'dni' => 'numeric | required',
      'name' => 'string | required',
      'last_name' => 'string | required',
      'sex' => 'string | required',
      'address' => 'string | required',
      'phone' => 'numeric | required',
      'mail' => 'string | required',
      // 'enabled' => 'boolean | required',
      'enabled' => 'required',
    ];

    $messages = [
      // 'dni.numeric' => 'El DNI debe ser un número',
      // 'dni.required' => 'El DNI es requerido',
      'name.string' => 'El nombre debe ser una cadena de texto',
      'name.required' => 'El nombre es requerido',
      'last_name.string' => 'El apellido debe ser una cadena de texto',
      'last_name.required' => 'El apellido es requerido',
      'sex.string' => 'El sexo debe ser una cadena de texto',
      'sex.required' => 'El sexo es requerido',
      'address.string' => 'La dirección debe ser una cadena de texto',
      'address.required' => 'La dirección es requerida',
      'phone.numeric' => 'El teléfono debe ser un número',
      'phone.required' => 'El teléfono es requerido',
      'mail.string' => 'El mail debe ser una cadena de texto',
      'mail.required' => 'El mail es requerido',
      'enabled.boolean' => 'La habilitación debe ser true o false',
      'enabled.required' => 'La habilitación es requerida',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());
      return response()->json($respuesta, 200);
    }

    $client = Client::find($request->id);

    if ($client) {

      $client->name = $request->name;
      $client->last_name = $request->last_name;
      $client->sex = $request->sex;
      $client->address = $request->address;
      $client->phone = $request->phone;
      $client->mail = $request->mail;
      $client->enabled = $request->enabled;

      if ($client->save()) {
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente actualizado con éxito', $client);
        return $respuesta;
      } else {
        $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', 'No se pudo actualizar el cliente');
        return $respuesta;
      }
    } else {
      $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontró el cliente', 'No se encontró el cliente');
      return $respuesta;
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Client $client)
  {
    //
  }

  /**
   * Eliminar un cliente.
   * @param  \Illuminate\Http\Request  $request
   */
  public function destroy($id)
  {
    $client = Client::destroy($id);

    if ($client) {
      $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente eliminado con éxito', '');
      return $respuesta;
    } else {
      $respuesta = APIHelpers::createAPIResponse(true, 500, 'No se encontró el cliente', 'No se encontró el cliente');
      return $respuesta;
    }
  }
}
