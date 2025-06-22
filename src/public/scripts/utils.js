String.prototype.strToElement = function() {
  return new DOMParser()
    .parseFromString(this, 'text/html')
    .body.children[0]
  ;
};

async function requestModal(url, config = {
  forceCancel: false,
  transitionState: true,
  success: ()=>{},
  error: ()=>{}
}) {

  const curtainNode = document.querySelector("curtain");
  curtainNode.style.display = "flex";

  const REQ = await fetch(url, {
    method: "GET"
  });

  if(REQ.status == 200) {

    let RES = await REQ.text();
    RES = RES.strToElement();

    if(RES instanceof Element ? RES.nodeName === "MODAL" : false) {
      
      const modalContainerNode = document.getElementById("modal-viewer");
      const requestUrlScript = await fetch(`/scripts${url.split("?")[0]}.js`);
      let urlScriptNode;

      if(requestUrlScript.status == 200) {
        urlScriptNode = document.createElement("script");
        urlScriptNode.innerHTML = await requestUrlScript.text();
      }

      if(config.transitionState) {
        modalContainerNode.style.transform = "scale(0)";

        setTimeout(() => {

          modalContainerNode.innerHTML = RES.innerHTML;
          modalContainerNode.style.transform = "scale(1)";
          curtainNode.style.display = "none";

          if(typeof config.success === "function")
            config.success();

          if(typeof urlScriptNode !== "undefined")
            modalContainerNode.append(urlScriptNode);

        }, 300);

      } else {

        modalContainerNode.innerHTML = RES.innerHTML;
        curtainNode.style.display = "none";

        if(typeof config.success === "function")
          config.success();

        if(typeof urlScriptNode !== "undefined")
          modalContainerNode.append(urlScriptNode);

      }

      return;

    } else if(typeof config.success === "function") config.success();
  }

  if(typeof config.error === "function")
    config.error();
  
  if(!config.forceCancel) {

    curtainNode.querySelector("h2");
    curtainNode.tmpInnerHTML = curtainNode.innerHTML;
    curtainNode.innerHTML = `<div style="
      align-items: center;
      background: white;
      border-radius: 10px;
      color: #ec7063;
      display: flex;
      padding:5px 10px;
    ">
      <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#ec7063"><path d="M391-240q17 0 32.5-6t30.5-14q6-4 12.5-7t13.5-3q8 0 26 10 15 8 30.5 14t32.5 6q50 0 80.5-35.5T680-370q0-72-49.5-111T488-520h-16q-93 0-142.5 39T280-370q0 59 30.5 94.5T391-240Zm-1-60q-24 0-37.5-18.5T339-370q0-46 32.5-68T472-460h15q68 0 100 22t32 68q0 33-13 51.5T569-300q-12 0-34-12-13-8-26.5-13t-28.5-5q-15 0-29 5t-27 13q-8 5-16.5 8.5T390-300ZM251-532q60-24 96-53t68-79l-50-32q-26 41-54.5 63T228-588l23 56Zm457 0 23-56q-53-22-81-44t-55-64l-50 32q32 50 68 78.5t95 53.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg>
      <span>&nbsp;&nbsp;</span>
      <h2>No se pudo cargar el modal</h2>
    </div>`;

    setTimeout(() => {
      curtainNode.innerHTML = curtainNode.tmpInnerHTML;
      curtainNode.style.display = "none";
    }, 2*1000);
    
  }

}
