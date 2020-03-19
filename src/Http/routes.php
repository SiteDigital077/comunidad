<?php

  Route::get('registro/pin', function(){
  $plantilla = \DigitalsiteSaaS\Pagina\Template::all();
  $menu = \DigitalsiteSaaS\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
   $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
     //dd($arr_ip);
     $ip = $arr_ip['ip'];

     $ciudad = $arr_ip['city'];
        
     $pais = $arr_ip['country'];
  return View::make('auth.loginpin')->with('plantilla', $plantilla)->with('menu', $menu)->with('ip', $ip)->with('ciudad', $ciudad)->with('pais', $pais);
 });
  
 Route::any('pruebas/pinregister', '\DigitalsiteSaaS\Comunidad\Http\ComunidadController@loginregister');

Route::group(['middleware' => ['web']], function (){
 Route::any('pruebas/login', '\DigitalsiteSaaS\Comunidad\Http\ComunidadController@login');




 Route::get('comunidad/nota/{id}', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@nota');
 Route::get('comunidad/notaweb/{id}', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@notaweb');
 Route::get('comunidad/digital/{id}', function($page){
  $plantilla = DigitalsiteSaaS\Comunidada\Template::all();
  $menu = DigitalsiteSaaS\Comunidad\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
  $areadina = DB::table('area_comunidades')->get();
  $parametrodina = DB::table('grado_comunidades')->get();
  $temasdina = DB::table('temas_comunidades')->get();
  $subtemasdina = DB::table('subtemas_comunidades')->get();
  $areadinamizador =  session()->get('areadina');
  $gradodinamizador = session()->get('gradodina');
  $campodinamizador = session()->get('campodina');
  $variabledinamizador = session()->get('variabledina'); 
  $casa =  session()->get('casa');
  $notas = DB::table('notas_comunidades')
  ->leftJoin('categoria_comunidades','categoria_comunidades.id','=','notas_comunidades.nota_comunidad_id')
  ->leftJoin('area_comunidades','area_comunidades.id','=','notas_comunidades.area_id')
  ->leftJoin('interes_comunidades', 'notas_comunidades.interes_id', '=', 'interes_comunidades.id')
  ->where('area_id', 'like', '%' . $areadinamizador . '%')
  ->where('parametro_id', 'like', '%' . $gradodinamizador . '%')
  ->where('tema_id', 'like', '%' . $campodinamizador . '%')
  ->where('subtema_id', 'like', '%' . $variabledinamizador . '%')
  ->where('categoria_comunidades.slug','=',$page)
  ->where('titulo','like','%'.$casa.'%')->where('keywords','like','%'.$casa.'%')
  ->orderByRaw("RAND()")
  ->paginate(12);
  return View::make('comunidad::comunidad')->with('notas', $notas)->with('plantilla', $plantilla)->with('menu', $menu)->with('areadina', $areadina)->with('parametrodina', $parametrodina)->with('temasdina', $temasdina)->with('subtemasdina', $subtemasdina);
 });

/*
Route::get('gestion/calendario/{id}', function($page){
  $plantilla = Digitalsite\Pagina\Template::all();
  $menu =  Digitalsite\Pagina\Page::whereNull('page_id')->orderBy('posta', 'desc')->get();
$calendario = DB::table('events')->where('slug', "=", $page)->get();
return View::make('pagina::calendario')->with('calendario', $calendario)->with('plantilla', $plantilla)->with('menu', $menu);
});
*/
});

Route::group(['middleware' => ['auths','administrador']], function (){
 Route::get('gestion/comunidad/crear/{id}', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@creareva');
 Route::get('gestion/comunidad/editar-nota/{id}', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editareva');
 Route::resource('gestion/comunidad/notas', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@vernotas');
 Route::resource('gestion/comunidad/documentos', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@verdocumentos');
 Route::resource('gestion/comunidad/crear-nota', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@crearnota');
 Route::resource('gestion/comunidad/editardocumento', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editardocumento');
 Route::resource('gestion/comunidad/eliminar-nota', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminarnota');
 Route::resource('gestion/comunidad/editar-nota', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarnota');
 Route::resource('gestion/comunidad/editar-documento', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editardocmento');
 Route::resource('gestion/comunidad/eliminar-documento', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminardocumento');
 Route::resource('gestion/comunidad/editar', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarnota');
 Route::resource('gestion/comunidad/temas', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@temas');
 Route::resource('gestion/comunidad/subtemas', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@subtemas');
 Route::resource('gestion/comunidad/creardocumento', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@creardocumento');
 Route::resource('gestion/comunidad/creartema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@creartemas');
 Route::resource('gestion/comunidad/subcreartema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@subcreartemas');
 Route::resource('gestion/comunidad/eliminar-tema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminartema');
 Route::resource('gestion/comunidad/eliminar-roles', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminarrols');
 Route::resource('gestion/comunidad/eliminar-subtema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminarsubtema');
 Route::resource('gestion/comunidad/editartema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editartema');
 Route::resource('gestion/comunidad/editarsubtema', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarsubtema');
 Route::resource('gestion/comunidad/crearcate-comunidad', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@crearcatecomunidad');
 Route::resource('gestion/comunidad/creararea', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@creararea');
 Route::resource('gestion/comunidad/creargrado', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@creargrado');
 Route::resource('gestion/comunidad/crearinteres', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@crearinteres');
 Route::resource('gestion/comunidad/crearrols', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@crearrols');
 Route::resource('gestion/comunidad/eliminar-categoria', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminarcategoria');
 Route::resource('gestion/comunidad/eliminar-area', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminararea');
 Route::resource('gestion/comunidad/eliminar-grado', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminargrado');
 Route::resource('gestion/comunidad/eliminar-interes', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@eliminarinteres');
 Route::resource('gestion/comunidad/editarcategoria', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarcategoria');
 Route::resource('gestion/comunidad/editararea', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editararea');
 Route::resource('gestion/comunidad/editargrado', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editargrado');
 Route::resource('gestion/comunidad/editarinteres', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarinteres');
 Route::resource('gestion/comunidad/editarroles', 'DigitalsiteSaaS\Comunidad\Http\ComunidadController@editarroles');
 Route::get('gestion/comunidad', function(){
  $categoria = DB::table('categoria_comunidades')->get();
  return View::make('comunidad::comunidad.index')->with('categoria', $categoria);
 });
 Route::get('gestion/comunidad/crear-general/{id}', function($id){
  $areas = DB::table('interes_comunidades')->get();
  $roles = DB::table('roles_comunidad')->get();
  $parametros = DB::table('parametro')->get();
  $temas = DB::table('temas_comunidades')->get();
  return View::make('comunidad::comunidad.crear-general')->with('areas', $areas)->with('parametros', $parametros)->with('temas', $temas)->with('roles', $roles);
 });
 Route::get('gestion/comunidad/crear-documento/{id}', function($id){
  return View::make('comunidad::comunidad.crear-documento');
 });
 Route::get('gestion/comunidad/editar-notaweb/{id}', function($id){
  $areas = DB::table('interes_comunidades')->get();
  $parametros = DB::table('parametro')->get();
  $roles = DB::table('roles_comunidad')->get();
  $notador = DB::table('notas_comunidades')->where('id','=',$id)->get();
  foreach ($notador as $notadores){
  $ideman = $notadores->roles;
  $id_str = explode(',', $ideman);
  $rols = DB::table('roles_comunidad')->whereIn('id', $id_str)->get();}
  $rolsas = DB::table('rols')->get();
  $notas = DB::table('notas_comunidades')
  ->leftJoin('interes_comunidades', 'notas_comunidades.interes_id', '=', 'interes_comunidades.id')
  ->where('notas_comunidades.id', '=' ,$id)->get();
  $temas = DB::table('temas_comunidades')->get();
  return View::make('comunidad::comunidad.editarweb')->with('areas', $areas)->with('parametros', $parametros)->with('notas', $notas)->with('temas', $temas)->with('rols', $rols)->with('notador', $notador)->with('rolsas', $rolsas)->with('roles', $roles);
 });
 Route::get('gestion/comunidad/editar-tema/{id}', function($id){
  $areaweb = DB::table('temas_comunidades')
  ->join('area_comunidades','area_comunidades.id','=','temas_comunidades.area_id')
  ->where('temas_comunidades.id','=',$id)->get();
  $grado = DB::table('temas_comunidades')
  ->join('grado_comunidades','grado_comunidades.id','=','temas_comunidades.grado_id')
  ->where('temas_comunidades.id','=',$id)->get();
  $area = DB::table('area_comunidades')->get();
  $temas = DB::table('temas_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-tema')->with('temas', $temas)->with('area', $area)->with('areaweb', $areaweb)->with('grado', $grado);
 });
 Route::get('gestion/comunidad/editar-subtema/{id}', function($id){
  $temas = DB::table('subtemas_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-subtema')->with('temas', $temas);
 });
 Route::get('gestion/comunidad/crear-tema', function(){
  $area = DB::table('area_comunidades')->get();
  return View::make('comunidad::comunidad.crear-tema')->with('area', $area);
 });
 Route::get('gestion/comunidad/crear-subtema/{id}', function(){
  return View::make('comunidad::comunidad.crear-subtema');
 });
 Route::get('gestion/comunidad/areas', function(){
  $areas = DB::table('area_comunidades')->get();
  return View::make('comunidad::comunidad.areas')->with('areas', $areas);
 });
 Route::get('gestion/comunidad/grados/{id}', function($id){
  $grados = DB::table('grado_comunidades')->where('area_id','=',$id)->get();
  return View::make('comunidad::comunidad.grados')->with('grados', $grados);
 });
 Route::get('gestion/comunidad/interes', function(){
  $areas = DB::table('interes_comunidades')->get();
  return View::make('comunidad::comunidad.interes')->with('areas', $areas);
 });
 Route::get('gestion/comunidad/roles', function(){
  $roles = DB::table('roles_comunidad')->get();
  return View::make('comunidad::comunidad.roles')->with('roles', $roles);
 });
 Route::get('gestion/comunidad/crear-categoria', function(){
  $areas = DB::table('areas')->get();
  return View::make('comunidad::comunidad.crear-categoria')->with('areas', $areas);
 });
 Route::get('gestion/comunidad/editar-categoria/{id}', function($id){
  $categoria = DB::table('categoria_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-categoria')->with('categoria', $categoria);
 });
 Route::get('gestion/comunidad/editar-area/{id}', function($id){
  $area = DB::table('area_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-area')->with('area', $area);
 });
 Route::get('gestion/comunidad/editar-grado/{id}', function($id){
  $grado = DB::table('grado_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-grado')->with('grado', $grado);
 });
 Route::get('gestion/comunidad/editar-interes/{id}', function($id){
  $area = DB::table('interes_comunidades')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-interes')->with('area', $area);
 });
 Route::get('gestion/comunidad/editar-roles/{id}', function($id){
  $roles = DB::table('roles_comunidad')->where('id', "=", $id)->get();
  return View::make('comunidad::comunidad.editar-roles')->with('roles', $roles);
 });
 Route::get('gestion/comunidad/crear-area', function(){
  return View::make('comunidad::comunidad.crear-area');
 });
 Route::get('gestion/comunidad/crear-grado/{id}', function(){
  return View::make('comunidad::comunidad.crear-grado');
 });
 Route::get('gestion/comunidad/crear-interes', function(){
  return View::make('comunidad::comunidad.crear-interes');
 });
 Route::get('gestion/comunidad/crear-area', function(){
  return View::make('comunidad::comunidad.crear-area');
 });
 Route::get('gestion/comunidad/crear-rols', function(){
  return View::make('comunidad::comunidad.crear-rols');
 });
});