<?php include 'templates/header.tpl';

 $structure = d('structure');
 $texts = d('texts');



  function render_content($structure, $texts, $level = 1){
    foreach($structure as $key => $value){
      $_key = is_array($value) ? $key : $value;
      $header = isset($texts['header'][$_key]) ? $texts['header'][$_key] : $_key.'_header';
      $content = isset($texts['text'][$_key]) ? $texts['text'][$_key] : '';
      
      $result = '<h'.$level.'><a class="name" name="'.$_key.'">'.$header.'</a></h'.$level.'>'."\n";
      if(!empty($content)) {
        $result .= '<div class="text '.$_key.'">'.htmlspecialchars_decode($content)
                .  '<a class="to_content_list" href="#top">'.t('to_content_list').'</a></div>'."\n";
      }
      if(is_array($value)){
        $result .= render_content($value, $texts, $level + 1);
      }
    }
    return $result;


    }



  function render_content_list($structure, $texts){
    $result = '<ul class="content_list">';
     // Tools::debug($texts);
    foreach($structure as $key => $value){
      $_key = is_array($value) ? $key : $value;
      $header = isset($texts['header'][$_key]) ? $texts['header'][$_key] : $_key.'_header';
      $result .= '<li><a href="#'.$_key.'">'.$header.'</a></li>';
      if(is_array($value)){
        $result .= render_content_list($value, $texts);
      }
    }
    $result .= '</ul>';
    return $result;
  }
  ?><a name="content_list"></a><?
   echo render_content_list($structure, $texts);
   echo render_content($structure, $texts);



  include 'templates/footer.tpl'; ?>
