<?php
/**
 * Expose author properties as a context condition.
 *
 * This plugin limits context based on authorship of
 * the current node.
 */
class asb_scheme_context_condition_author extends context_condition {
  function condition_values() {
    $values = array();
    $values['is_author'] = check_plain("Author of post");
    $values['is_not_author'] = check_plain("Is not Author of post");
    return $values;
  }

  function execute($node) {
    global $user;
    if($user->uid == $node->uid) {
      foreach ($this->get_contexts('is_author') as $context) {
        $this->condition_met($context, 'is_author');
      }
    }else{
      foreach ($this->get_contexts('is_not_author') as $context) {
        $this->condition_met($context, 'is_not_author');
      }
    }
  }
}
