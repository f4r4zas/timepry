<?php
mk_hpostform($base_url."menu_manipulate".(isset($data['menu_id'])?"/".$data['menu_id']:""));
//mk_hselect_faicon("data[menu_icon]",_l('Icon',$this),$faicons,isset($data['menu_icon'])?$data['menu_icon']:null,null,'style="width:200px"');
mk_htext("data[menu_name]",_l('Title',$this),isset($data['menu_name'])?$data['menu_name']:'');
foreach ($languages as $item) {
    $languageIcon = ' <img src="'.base_url().$item["image"].'" style="width:26px;" alt="'.$item["language_name"].'" title="'.$item["language_name"].'">';
    mk_htext("data[titles][".$item["language_id"]."]",_l('Title',$this).$languageIcon,isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"");
}
//                mk_hselect("data[page_id]",_l('Type',$this),$pages,"page_id","page_name",isset($data['page_id'])?$data['page_id']:null,"<--"._l("use link",$this)."-->");
mk_htext("data[menu_url]",_l('URL / URI',$this),isset($data['menu_url'])?$data['menu_url']:'',"style='direction:ltr'");
mk_hnumber("data[menu_order]",_l('Order',$this),isset($data['menu_order'])?$data['menu_order']:'');
mk_hcheckbox("data[public]",_l('Public',$this),(isset($data['public']) && $data['public']==1)?1:null);

mk_hsubmit(_l('Submit',$this),$base_url."edit".$page,_l('Cancel',$this));
mk_closeform();
?>