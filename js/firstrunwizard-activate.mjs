function __vite__mapDeps(indexes) {
  if (!__vite__mapDeps.viteFileDeps) {
    __vite__mapDeps.viteFileDeps = [OC.filePath('firstrunwizard', '', 'js/main-ABl-s2Y1.mjs'),OC.filePath('firstrunwizard', '', 'css/firstrunwizard-main.css')]
  }
  return indexes.map((i) => __vite__mapDeps.viteFileDeps[i])
}
/*! third party licenses: js/vendor.LICENSE.txt */
import{_ as t}from"./modulepreload-polyfill-DDskOgo1.mjs";document.addEventListener("DOMContentLoaded",async function(){(await t(()=>import("./main-ABl-s2Y1.mjs"),__vite__mapDeps([0,1]),import.meta.url)).open()});
