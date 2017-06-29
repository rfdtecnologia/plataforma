<?php
Conectar();
$organizacion = $_SESSION["usuario_organizacion"];
?>
<div class="form-group">
  <label for="genero" class="col-sm-2 control-label">Género<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="genero" name="genero">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaGenero();
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="est_civil" class="col-sm-2 control-label">Estado Civil<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="est_civil" name="est_civil">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaEstadoCivil();
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="a_vivienda" class="col-sm-2 control-label">Área de Vivienda<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="a_vivienda" name="a_vivienda">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaAreaVivienda();
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="a_economica" class="col-sm-2 control-label">Actividad Económica<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="a_economica" name="a_economica">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaActividadEconomica();
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="n_instruccion" class="col-sm-2 control-label">Nivel de Instrucción<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="n_instruccion" name="n_instruccion">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaInstruccion();
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="agencia" class="col-sm-2 control-label">Oficina<span class="c_o">*</span></label>
  <div class="col-sm-10">
    <select class="form-control" id="agencia" name="agencia">
      <option value="0">-- SELECCIONE --</option>
      <?php
      listaAgencias($organizacion);
      ?>
    </select>
  </div>
</div>
<?php Desconectar(); ?>
