<form action="vaihda_salasana.php" method="POST">
    <label for="vanha_salasana">Vanha salasana</label>
    <input type="password" class="form-control" name="vanha_salasana">
    <label for="uusi_salasana">Uusi salasana</label>
    <input type="password" class="form-control" name="uusi_salasana">
    <label for="uusi_salasana_uudelleen">Uudelleen</label>
    <input type="password" class="form-control" name="uusi_salasana_uudelleen">
    <button class="btn btn-default" type="submit">Tallenna</button>
    <input type="hidden" name="vaihda" value="TRUE">
</form>
