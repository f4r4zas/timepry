<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 1/11/2016
 * Time: 9:47 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */
?>
<script>
    var baseURL = '<?php echo base_url(); ?>';
    var iframeURL = '<?php echo base_url().$lang.$this->provider_prefix; ?>/compact';
    var myScript = document.getElementById('btnNodAPS');
    var ifrm = document.createElement('IFRAME');

    // Make a button for load popup
    var btn = document.createElement('BUTTON');
    btn.id = 'appointmentPopuoBtn';
    // Button styles
    btn.innerText = '<?php echo $btnText; ?>';
    <?php if(isset($btnClass)){ ?>
    btn.className = '<?php echo $btnClass; ?>';
    <?php } ?>
    <?php if(isset($btnColor)){ ?>
    btn.style.color = '<?php echo $btnColor; ?>';
    <?php } ?>
    <?php if(isset($btnPadding)){ ?>
    btn.style.padding = '<?php echo $btnPadding; ?>px';
    <?php } ?>
    <?php if(isset($btnBorderRadius)){ ?>
    btn.style.borderRadius = '<?php echo $btnBorderRadius; ?>px';
    <?php } ?>
    <?php if(isset($btnBorder)){ ?>
    btn.style.border = '<?php echo $btnBorder; ?>px solid';
    <?php } ?>
    <?php if(isset($btnBorderColor)){ ?>
    btn.style.borderColor = '<?php echo $btnBorderColor; ?>';
    <?php } ?>
    <?php if(isset($btnBgColor)){ ?>
    btn.style.background = '<?php echo $btnBgColor; ?>';
    btn.onmouseout = function () {
        btn.style.background = '<?php echo $btnBgColor; ?>';
    };
    <?php } ?>
    <?php if(isset($btnHoverBgColor)){ ?>
    btn.onmouseover = function () {
        btn.style.background = '<?php echo $btnHoverBgColor; ?>';
    };
    btn.style.transition = 'all 500ms';
    <?php } ?>
    // Close popup
    btn.onclick = function(){
        // !IMPORTANT iframe src should be set
        ifrm.src = iframeURL;
        popWin.style.top = '10px';
        popWin.style.opacity = 1;
        ifrmBG.style.display = 'block';
        ifrmBG.style.opacity = 1;
    };
    // Add button before Script tag
    myScript.parentNode.insertBefore(btn,myScript);

    var animate=true;
    //alert(myScript.getAttribute('animate'));
    if(myScript.getAttribute('animate') && myScript.getAttribute('animate')=='false'){
        animate=false;
    }

    // !IMPORTANT iframe src should be set
//    ifrm.src = iframeURL;
    // iframe styles
    ifrm.style.width = '100%';
    ifrm.style.height = '100%';
    ifrm.style.border = 0;

    // Popup Background element
    var ifrmBG = document.createElement('div');
    ifrmBG.id = 'ifrmBG';
    // Popup Background style
    ifrmBG.style.position = 'fixed';
    ifrmBG.style.top = 0;
    ifrmBG.style.left = 0;
    ifrmBG.style.zIndex = '99999';
    ifrmBG.style.background = 'rgba(0,0,0,.4)';
    ifrmBG.style.width = 100 + '%';
    ifrmBG.style.height = 100 + '%';
    ifrmBG.style.transition = 'all 500ms';
    ifrmBG.style.opacity = 0;
    ifrmBG.style.display = 'none';
    // Close popup
    ifrmBG.onclick = function(){
        popWin.style.top = '-600px';
        popWin.style.opacity = 0;
        ifrmBG.style.opacity = 0;
        ifrmBG.style.display = 'none';
        ifrm.src = '';
    };
    // Add Popup background end of body
    document.body.appendChild(ifrmBG);


    // Popup Windows element
    var popWin = document.createElement('div');
    popWin.id = 'popWin';
    // Popup Windows style
    popWin.style.position = 'fixed';

    popWin.style.top = '-600px';
    popWin.style.left = '50%';
    popWin.style.width = '500px';
    popWin.style.height = '500px';
    popWin.style.marginLeft = '-250px';
    popWin.style.overflow = 'hidden';
    popWin.style.zIndex = '99999';
    popWin.style.background = 'rgba(255,255,255,1) url(' + baseURL + 'assets/reservation/img/loading.gif) no-repeat top';
    popWin.style.transition = 'all 500ms';
    // Add Popup background end of body
    document.body.appendChild(popWin);
    // Add iframe (popuo windows) at first of body
    popWin.insertBefore(ifrm,popWin.childNodes[0]);

</script>
