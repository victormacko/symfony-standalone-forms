<?  if(isset($label_attr['class']) && strpos($label_attr['class'], '-inline') !== false) {     ?>
<div class="control-group">
<?  } else { ?>
<div <?php echo $view['form']->block($form, 'widget_container_attributes') ?>>
<?  } ?>
<?php foreach ($form as $child): ?>
    <?php echo $view['form']->widget($child, array(
        'parent_label_class' => (isset($label_attr['class']) ? $label_attr['class'] : ''),
        'translation_domain' => $choice_translation_domain)) ?>
<?php endforeach ?>
</div>
