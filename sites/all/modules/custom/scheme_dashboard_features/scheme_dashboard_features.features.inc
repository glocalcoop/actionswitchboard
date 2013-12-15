<?php
/**
 * @file
 * scheme_dashboard_features.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function scheme_dashboard_features_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "quicktabs" && $api == "quicktabs") {
    return array("version" => "1");
  }
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_default_message_type().
 */
function scheme_dashboard_features_default_message_type() {
  $items = array();
  $items['scheme_membership'] = entity_import('message_type', '{
    "name" : "scheme_membership",
    "description" : "Scheme membership",
    "argument_keys" : [],
    "argument" : [],
    "category" : "message_type",
    "data" : {
      "token options" : { "clear" : 0 },
      "purge" : { "override" : 0, "enabled" : 0, "quota" : "", "days" : "" }
    },
    "language" : "en",
    "arguments" : null,
    "message_text" : { "und" : [
        {
          "value" : "\\u003Cp\\u003E[message:user:picture]\\u003C\\/p\\u003E",
          "format" : "filtered_html",
          "safe_value" : " \\u003Cp\\u003E[message:user:picture]\\u003C\\/p\\u003E\\n "
        },
        {
          "value" : "\\u003Cp\\u003E\\u003Ca href=\\u0022[message:user:url]\\u0022\\u003E@{message:user:name}\\u003C\\/a\\u003E joined \\u003Ca href=\\u0022[message:field-node-groups-ref:0:url]\\u0022\\u003E[message:field-node-groups-ref:0:title]\\u003C\\/a\\u003E group.\\u003C\\/p\\u003E",
          "format" : "full_html",
          "safe_value" : " \\u003Cp\\u003E\\u003Ca href=\\u0022[message:user:url]\\u0022\\u003E@{message:user:name}\\u003C\\/a\\u003E joined \\u003Ca href=\\u0022[message:field-node-groups-ref:0:url]\\u0022\\u003E[message:field-node-groups-ref:0:title]\\u003C\\/a\\u003E group.\\u003C\\/p\\u003E\\n "
        }
      ]
    },
    "rdf_mapping" : []
  }');
  $items['update_posted_in_scheme'] = entity_import('message_type', '{
    "name" : "update_posted_in_scheme",
    "description" : "Update posted in scheme",
    "argument_keys" : [ "!groups" ],
    "argument" : [],
    "category" : "message_type",
    "data" : {
      "token options" : { "clear" : 0 },
      "purge" : { "override" : 0, "enabled" : 0, "quota" : "", "days" : "" }
    },
    "language" : "en",
    "arguments" : null,
    "message_text" : { "und" : [
        {
          "value" : "\\u003Cp\\u003E[message:user:name]\\u003C\\/p\\u003E",
          "format" : "filtered_html",
          "safe_value" : " \\u003Cp\\u003E[message:user:name]\\u003C\\/p\\u003E\\n "
        },
        {
          "value" : "\\u003Cp\\u003E!groups\\u003C\\/p\\u003E",
          "format" : "full_html",
          "safe_value" : " \\u003Cp\\u003E!groups\\u003C\\/p\\u003E\\n "
        },
        {
          "value" : "\\u003Cp\\u003E[message:field-node-ref:node-teaser]\\u003C\\/p\\u003E",
          "format" : "filtered_html",
          "safe_value" : " \\u003Cp\\u003E[message:field-node-ref:node-teaser]\\u003C\\/p\\u003E\\n "
        },
        {
          "value" : "\\u003Cp\\u003E\\u003Ca title=\\u0022Insert this token into your form\\u0022\\u003E[message:timestamp:since]\\u003C\\/a\\u003E\\u003C\\/p\\u003E",
          "format" : "full_html",
          "safe_value" : " \\u003Cp\\u003E\\u003Ca title=\\u0022Insert this token into your form\\u0022\\u003E[message:timestamp:since]\\u003C\\/a\\u003E\\u003C\\/p\\u003E\\n "
        }
      ]
    },
    "rdf_mapping" : []
  }');
  return $items;
}
