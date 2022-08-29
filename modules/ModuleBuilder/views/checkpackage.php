<?php
class ModuleBuilder_checkpackage_View extends Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
	$qualifiedModuleName = $request->getModule(false);
	$viewer = $this->getViewer($request);	

	}
}
?>