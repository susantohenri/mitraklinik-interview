<form action="<?= site_url($current['controller']) ?>" class="form-groups" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<input type="hidden" name="last_submit" value="<?= time() ?>">

<?php foreach ($form as $field) : ?>
<div class="form-group row">
  <label class="col-sm-3 control-label"><?= 'hidden' === $field['type'] ? '' : $field['label'] ?></label>
  <div class="col-sm-7">
    <?php if(in_array($field['type'], array('text', 'hidden'))): ?>
      <input class="form-control" type="<?= $field['type'] ?>" value="<?= $field['value'] ?>" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
    <?php elseif('select' === $field['type']): ?>
        <?php
        if(preg_match('/(multiple)/', $field['attr']) > 0){
            echo '<input type="hidden" name="'.str_replace('[]','',$field['name']).'">';
        }
        ?>
      <select class="form-control" name="<?= $field['name'] ?>" <?= $field['attr'] ?>>
        <?php foreach ($field['options'] as $opt): ?>
        <option <?= $opt['value'] === $field['value'] || (is_array($field['value']) && in_array($opt['value'], $field['value'])) ? 'selected="selected"':'' ?> value="<?= $opt['value'] ?>"><?= $opt['text'] ?></option>
        <?php endforeach ?>
      </select>
    <?php elseif('tel' === $field['type']):?>
        <?php tel_input($field['name'], $field['value'], $field['attr'])?>
    <?php endif ?>
  </div>
</div>
<?php endforeach ?>

<div class="form-group row">
  <div class="col-sm-7 col-sm-offset-3">
    <button class="btn btn-primary"><i class="fa fa-save"></i> &nbsp; Save</button>
    <?php if (!empty ($uuid)): ?>
    <a href="<?= site_url($current['controller'] . "/delete/$uuid") ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> &nbsp; Delete</a>
    <?php endif ?>
    <a href="<?= site_url($current['controller']) ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp; Cancel</a>
  </div>
</div>
</form>