<br>

<button name="BSAVE" class="BOTO_ACTIVITAT" onClick="return confirm('Segur que vols guardar els canvis?')">
	<?php echo image_tag('template/disk.png').' Guardar i sortir' ?>
</button>
<button name="BDELETE" class="BOTO_PERILL" onClick="return confirm('Segur que vols esborrar <?php echo $element ?>? No ho podràs recuperar! ')">
	<?php echo image_tag('tango/16x16/status/user-trash-full.png').' Esborrar fitxa' ?>
</button>