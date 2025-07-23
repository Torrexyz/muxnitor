String.prototype.strToElement = function() {
  return new DOMParser()
    .parseFromString(this, 'text/html')
    .body.children[0]
  ;
};

/*<><><><><><><><><><>*/

async function requestModal(url, config = {}) {

  Array.from(event.target.parentNode.children).forEach(buttonNode => {
    if(buttonNode === event.target) {
      buttonNode.style.opacity = .7;
      buttonNode.style.transform = 'scale(0.9)';
    } else {
      buttonNode.style.opacity = 1;
      buttonNode.style.transform = 'scale(1)';
    }
  });

  /*..........*/

  if(typeof config.unerrorState === "undefined")
    config.unerrorState = false;
  if(typeof config.transitionState === "undefined")
    config.transitionState = true;
  if(typeof config.success === "undefined")
    config.success = ()=>{};
  if(typeof config.error === "undefined")
    config.error = ()=>{};
  if(typeof config.centerContent === "undefined")
    config.centerContent = false;
  if(typeof config.params === "undefined")
    config.params = new FormData();

  /*..........*/

  const curtainNode = document.querySelector("curtain");
  curtainNode.style.display = "flex";

  const REQ = await fetch(url, Object.assign(
    { method: config.method || "GET" },
    config.method === 'POST' ? { body: config.params } : {}
  ));

  /*..........*/

  if(REQ.ok) {

    let RES = await REQ.text();
    RES = RES.strToElement();

    if(RES instanceof Element ? RES.nodeName === "MODAL" : false) {
      const modalNode = document.getElementById("modal-viewer");
      
      let loadScriptNodes = [];
      try {
        const modalScript = await fetch(`/scripts${url.split("?")[0]}.js`);

        if(modalScript.ok) {
          let localScriptNode = document.createElement("script");
          localScriptNode.innerHTML = await modalScript.text();
          loadScriptNodes.push(localScriptNode);
        }
      } catch {}

      let loadStyleNode = false;
      try {
        const modalStyle = await fetch(`/styles${url.split("?")[0]}.css`);

        if(modalStyle.ok) {
          let localStyleNode = document.createElement("style");
          localStyleNode.innerHTML = await modalStyle.text();
          loadStyleNode = localStyleNode;
        }
      } catch {}

      /*..........*/

      if(config.transitionState)
        modalNode.style.transform = "scale(0)";

      setTimeout(() => {

        modalNode.innerHTML = RES.innerHTML;

        if(config.transitionState)
          modalNode.style.transform = "scale(1)";

        curtainNode.style.display = "none";

        let dispatchNode = document.createElement("script");
        dispatchNode.innerHTML = "document.dispatchEvent(new Event('ModalDOMContentLoaded'))";
        modalNode.append(dispatchNode);

      }, config.transitionState ? 300 : 0);

      /*..........*/

      document.addEventListener("ModalDOMContentLoaded", function handler(evnt) {
        modalNode.removeAttribute("style");
        config.success();

        if(config.centerContent) {
          modalNode.setAttribute("center-content", null);
        } else modalNode.removeAttribute("center-content");

        if(loadScriptNodes.length > 0)
          loadScriptNodes.forEach(scriptNode => modalNode.append(scriptNode));

        if(loadStyleNode instanceof Element)
          modalNode.insertBefore(loadStyleNode, modalNode.firstElementChild);

        if(typeof RES.style !== "undefined")
          modalNode.setAttribute("style", RES.getAttribute("style"));

        modalNode.querySelectorAll("script[reload]").forEach(scriptNode => {
          let localScriptNode = document.createElement("script");
          localScriptNode.innerHTML = scriptNode.innerHTML;
          scriptNode.parentNode.replaceChild(localScriptNode, scriptNode);
        });

        evnt.currentTarget.removeEventListener(evnt.type, handler);
      });

      return;

    }
  }

  config.error();
  if(!config.unerrorState) {

    curtainNode.querySelector("h2");
    curtainNode.tmpInnerHTML = curtainNode.innerHTML;
    curtainNode.innerHTML = `<div>
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

function requestPostModal(formNode, config) {
  event.preventDefault();

  const bodyRequest = new FormData(formNode);
  bodyRequest.append(event.target.getAttribute("name"), event.target.value);

  if(formNode instanceof Element ? formNode.nodeName === "FORM" : false) {
    requestModal(
      `${(new URL(formNode.action)).pathname}${(new URL(formNode.action)).search}`,
      Object.assign(config, { method: "POST", params: bodyRequest })
    );
  }
}

/*..........*/

function setClipboard(texto) {
  const textarea = document.createElement('textarea');
  textarea.value = texto;
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand('copy')
  document.body.removeChild(textarea);
}
