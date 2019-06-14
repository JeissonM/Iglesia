<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auditoriacomunicacion;
use App\Auditoriafeligresia;
use App\Auditoriagestiondocumental;
use App\Auditoriausuario;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller {

    public function index($modulo) {
        $data = null;
        switch ($modulo) {
            case 'USUARIOS':
                $data = Auditoriausuario::all();
                break;
            case 'FELIGRESIA':
                $data = Auditoriafeligresia::all();
                break;
            case 'GESTION DOCUMENTAL':
                $data = Auditoriagestiondocumental::all();
                break;
            case 'COMUNICACION':
                $data = Auditoriacomunicacion::all();
                break;
            default:
                return redirect()->route('admin.auditoria');
        }
        return view('auditoria.list')
                        ->with('location', 'auditoria')
                        ->with('data', $data)
                        ->with('f1', '')
                        ->with('f2', '')
                        ->with('modulo', $modulo);
    }

    public function filtro(Request $request) {
        $data = null;
        switch ($request->modulo) {
            case 'USUARIOS':
                $data = DB::table('auditoriausuarios')
                                ->whereBetween('created_at', [$request->f1, $request->f2])->get();
                break;
            case 'FELIGRESIA':
                $data = DB::table('auditoriafeligresias')
                                ->whereBetween('created_at', [$request->f1, $request->f2])->get();
                break;
            case 'GESTION DOCUMENTAL':
                $data = DB::table('auditoriagestiondocumentals')
                                ->whereBetween('created_at', [$request->f1, $request->f2])->get();
                break;
            case 'COMUNICACION':
                $data = DB::table('auditoriacomunicacions')
                                ->whereBetween('created_at', [$request->f1, $request->f2])->get();
                break;
            default:
                return redirect()->route('admin.auditoria');
        }
        return view('auditoria.list')
                        ->with('location', 'auditoria')
                        ->with('data', $data)
                        ->with('f1', $request->f1)
                        ->with('f2', $request->f2)
                        ->with('modulo', $request->modulo);
    }

    public function txt($modulo, $f1, $f2) {
        $data = null;
        if ($f1 == 'NO') {
            switch ($modulo) {
                case 'USUARIOS':
                    $data = Auditoriausuario::all();
                    break;
                case 'FELIGRESIA':
                    $data = Auditoriafeligresia::all();
                    break;
                case 'GESTION DOCUMENTAL':
                    $data = Auditoriagestiondocumental::all();
                    break;
                case 'COMUNICACION':
                    $data = Auditoriacomunicacion::all();
                    break;
                default:
                    return redirect()->route('admin.auditoria');
            }
        } else {
            switch ($modulo) {
                case 'USUARIOS':
                    $data = DB::table('auditoriausuarios')
                                    ->whereBetween('created_at', [$f1, $f2])->get();
                    break;
                case 'FELIGRESIA':
                    $data = DB::table('auditoriafeligresias')
                                    ->whereBetween('created_at', [$f1, $f2])->get();
                    break;
                case 'GESTION DOCUMENTAL':
                    $data = DB::table('auditoriagestiondocumentals')
                                    ->whereBetween('created_at', [$f1, $f2])->get();
                    break;
                case 'COMUNICACION':
                    $data = DB::table('auditoriacomunicacions')
                                    ->whereBetween('created_at', [$f1, $f2])->get();
                    break;
                default:
                    return redirect()->route('admin.auditoria');
            }
        }
        $response = null;
        if ($data != null) {
            if (count($data) > 0) {
                $hoy = getdate();
                $response[] = "**********************************************************************************";
                $response[] = " LOG DE AUDITORÍA DEL SISTEMA, MÓDULO: " . $modulo . ". FECHA: " . $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
                $response[] = "**********************************************************************************";
                $response[] = "                                                                        ";
                $response[] = "                                                                        ";
                foreach ($data as $d) {
                    $response[] = "USUARIO " . $d->usuario;
                    $response[] = "OPERACIÓN: " . $d->operacion;
                    $response[] = "FECHA: " . $d->created_at;
                    $response[] = "DETALLES: " . $d->detalles;
                    $response[] = "__________________________________________________________________________________";
                }
                $archivo = "LOG_AUDITORIA_MODULO_" . $modulo . "_" . "_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . ".txt";
                $file = fopen(public_path() . "/docs/auditoria/" . $archivo, 'w+');
                foreach ($response as $value) {
                    fwrite($file, $value . PHP_EOL);
                }
                fclose($file);
                flash()->success("Archivo de log generado con exito, <b><a href='" . asset("/docs/auditoria/" . $archivo)."' target='_blank' style='color: #ffffff'>PROCEDA A DESCARGARLO DESDE AQUÍ!.</a></b>");
                return view('auditoria.list')
                                ->with('location', 'auditoria')
                                ->with('data', $data)
                                ->with('f1', $f1)
                                ->with('f2', $f2)
                                ->with('modulo', $modulo);
            } else {
                flash('No hay resultados para su consulta')->error();
                return redirect()->route('admin.auditoria');
            }
        } else {
            flash('No hay resultados para su consulta')->error();
            return redirect()->route('admin.auditoria');
        }
    }

}
