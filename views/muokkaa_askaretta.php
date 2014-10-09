<h1>Muokkaa askaretta</h1>
    <form action="muokkaa_askaretta.php" method="POST">
        <input type="hidden" name="modify" value="TRUE">
        <input type="text" class="form-control" name="kuvaus" placeholder="Askare"
            value="<?php echo htmlspecialchars($data->askare->get_kuvaus()); ?>">
    
    <input type="hidden" name="id" value="<?php echo $data->askare->get_id(); ?>">
    <h3>Tärkeys<h3>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys" value="1"
        <?php if ($data->askare->get_tarkeys() == 1): ?>
            checked
        <?php endif; ?>>1</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys" value="2"
        <?php if ($data->askare->get_tarkeys() == 2): ?>
            checked
        <?php endif; ?>>2</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys" value="3"
        <?php if ($data->askare->get_tarkeys() == 3): ?>
            checked
        <?php endif; ?>>3</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys" value="4"
        <?php if ($data->askare->get_tarkeys() == 4): ?>
            checked
        <?php endif; ?>>4</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys" value="5"
        <?php if ($data->askare->get_tarkeys() == 5): ?>
            checked
        <?php endif; ?>>5</label>
    </div>

    <h2>Luokat</h2>
    <table class="table">
            <tr> 
                <td>Uusi luokka</td><td><input type="text" name="uusi_luokka" placeholder="Luokka"></td>
                <td>
                    <label>Yliluokka</label>
                    <select name="yliluokka_id">
                        <option value=''>Valitse</option>
                        <option value=''>-----</option>
                    <?php foreach($data->luokat as $luokka) : ?>
                        <option value="<?php echo $luokka->get_id(); ?>">
                            <?php echo $luokka->get_nimi(); ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php foreach($data->luokat as $luokka) : ?>
                <tr> <td><input type="checkbox" name="<?php echo $luokka->get_id(); ?>"
                            <?php if (in_array($luokka->get_id(), $data->askare->get_luokat())): ?>
                                checked
                            <?php endif; ?>></td><td>
                <?php echo $luokka->get_nimi() ?></td><td></td></tr> 
            <?php endforeach; ?>
    </table>
    <button class="btn btn-default" type="submit">Tallenna</button>
    </form>
