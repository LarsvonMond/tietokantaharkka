<div class="btn-group">
    <a href="suodata.php" class="btn btn-default">Suodata</a>
</div>
<div>
    <table class="table">
        <tr> <th>Askare</th><th>Luokat</th><th>Tärkeysaste</th><th></th><th></th></tr>  
        <?php foreach($data->askareet as $askare): ?>
            <tr> <td><?php echo htmlspecialchars($askare->get_kuvaus()); ?> </td> 
            <td><?php $pilkkulaskuri = 1; $luokkia = count($askare->get_luokat()); ?>
                <?php foreach($askare->get_luokat() as $luokka): ?>
                    <?php echo htmlspecialchars($luokka);
                          if ($pilkkulaskuri < $luokkia) {
                              echo ", ";
                          } 
                          $pilkkulaskuri += 1; ?>
                <?php endforeach; ?></td>
            <td><?php echo htmlspecialchars($askare->get_tarkeys()); ?></td>
            <td><a href="muokkaa_askaretta.php?id=<?php echo htmlspecialchars($askare->get_id()); ?>">
                Muokkaa</a>
            <td>
                <form action="muokkaa_askaretta.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($askare->get_id()); ?>">
                    <input type="hidden" name="delete" value="TRUE">
                    <button class="btn btn-default" type="submit">Poista</button>
                </form>
            </td></tr>
        <?php endforeach; ?>
    </table>
</div>
