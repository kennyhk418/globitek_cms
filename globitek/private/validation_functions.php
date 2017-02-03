<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    $len = strlen($value);
    if(isset($options['max']) && ($len > $options['max']))
      return false;
    elseif(isset($options['min']) && ($len < $options['min']))
      return false;
    elseif(isset($options['exact']) && ($len != $options['exact']))
      return false;
    else
      return true;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    if(strpos($value,'@') && preg_match('/\A[A-Za-z\d\_\@\.]+\Z/', $value))
      return true;
  }

?>
