function __vite__mapDeps(indexes) {
  if (!__vite__mapDeps.viteFileDeps) {
    __vite__mapDeps.viteFileDeps = [OC.filePath('firstrunwizard', '', 'js/main-nD_9sdBo.mjs'),OC.filePath('firstrunwizard', '', 'css/firstrunwizard-main.css')]
  }
  return indexes.map((i) => __vite__mapDeps.viteFileDeps[i])
}
/*! third party licenses: js/vendor.LICENSE.txt */
import{_ as i}from"./modulepreload-polyfill-DDskOgo1.mjs";document.addEventListener("DOMContentLoaded",function(){const o=document.querySelector("#firstrunwizard_about button"),t=()=>{document.querySelector("#firstrunwizard_about button").addEventListener("click",async function(e){var n;e.stopPropagation(),e.preventDefault();const r=(n=document.querySelector('[aria-controls="header-menu-user-menu"]'))!=null?n:void 0,{open:u}=await i(()=>import("./main-nD_9sdBo.mjs"),__vite__mapDeps([0,1]),import.meta.url);u(r),OC.hideMenus(()=>!1)})};o?t():window._nc_event_bus.subscribe("core:user-menu:mounted",t)});
