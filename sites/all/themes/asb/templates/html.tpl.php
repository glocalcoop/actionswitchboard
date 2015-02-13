<?php
/**
 * @file
 * Returns the HTML for the basic html structure of a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728208
 */
?><!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" <?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7" <?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8" <?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9" <?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html <?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->

<head>


  <?php print $head; ?>

<!-- favicon wranglin -->
  <link rel="apple-touch-icon" href="/touch-icon.png">
  <link rel="icon" href="/favicon.png">
  <!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
  <!-- or, set /favicon.ico for IE10 win -->
  <meta name="msapplication-TileColor" content="#f00">
  <meta name="msapplication-TileImage" content="/tileicon.png">
<!-- end favicon bonanza -->

  <title><?php print $head_title; ?></title>

  <?php if ($default_mobile_metatags): ?>
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width">
  <?php endif; ?>
  <meta http-equiv="cleartype" content="on">

  <?php print $styles; ?>
  <?php print $scripts; ?>
  <?php if ($add_html5_shim and !$add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/html5.js"></script>
    <![endif]-->
  <?php elseif ($add_html5_shim and $add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/html5-respond.js"></script>
    <![endif]-->
  <?php elseif ($add_respond_js): ?>
    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_zen; ?>/js/respond.js"></script>
    <![endif]-->
  <?php endif; ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <?php if ($skip_link_text && $skip_link_anchor): ?>
    <p id="skip-link">
      <a href="#<?php print $skip_link_anchor; ?>" class="element-invisible element-focusable"><?php print $skip_link_text; ?></a>
    </p>
  <?php endif; ?>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

  <div id="newsletterModal" class="hidden">

    <div class="ctools-modal-content ctools-modal-asb-modal-update">

      <div class="modal-content-wrapper">

        <header class="modal-head-wrapper">
          <h3 class="modal-title" >Sign up for the Mailing List</h3>
          <a class="close" href="#"><span>Close Window</span></a>
        </header>

        <div class="modal-scroll">

          <div id="modal-content" class="modal-content popups-body" style="width: 675px; height: 455px;">

            <form  action="https://actionswitchboard.net/civicrm/profile/create?gid=43&amp;reset=1" method="post" name="Edit" id="Edit" >

              <div>
                <input name="entryURL" type="hidden" value="https://actionswitchboard.net/civicrm/profile/create?gid=43&amp;reset=1/field/add?reset=1&amp;amp;action=add&amp;amp;gid=43" />
                <input id="profileId" type="hidden" value="43" />
                <input id="postURL" name="postURL" type="hidden" value="" />
                <input id="cancelURL" name="cancelURL" type="hidden" value="https://actionswitchboard.net/civicrm/profile?reset=1&amp;gid=43" />
                <input id="groupId" name="add_to_group" type="hidden" value="131" />
                <input name="_qf_default" type="hidden" value="Edit:cancel" />
              </div>

              <div class="crm-profile-name-ASB_Newsletter_43">
                <h3 id="newsletterResponse"></h3>
                <div id="crm-container" class="crm-container crm-public" lang="en" xml:lang="en">

                  <div id="editrow-email-Primary" class="crm-section editrow_email-Primary-section form-item">
                      <input placeholder="Enter your eamil…" maxlength="254" size="20" name="email-Primary" type="text" id="email-Primary" class="form-text medium required" />
                  </div>
                  <div class="crm-submit-buttons" style=''>
                    <input class="button validate form-submit default" accesskey="S" name="_qf_Edit_next" value="Save" type="submit" id="_qf_Edit_next" />
                    <input class="button cancel form-submit default" name="_qf_Edit_cancel" value="Cancel" type="submit" id="_qf_Edit_cancel" />
                  </div>

                </div>

              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
