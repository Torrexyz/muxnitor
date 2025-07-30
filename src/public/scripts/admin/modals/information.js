document.getElementById("file-chooser").onchange = (evnt) => {

  if(!evnt.target.hasOwnProperty("filesContainer"))
    evnt.target.filesContainer = [];

  const fileInfo = evnt.target.files[0];
  evnt.target.filesContainer.push(fileInfo);

  if(fileInfo) {

    const getIconFile = (fileName) => {
      if(fileName.includes('image/')) {
        return '<svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm40-80h480L570-480 450-320l-90-120-120 160Zm-40 80v-560 560Z"/></svg>';
      } else if(fileName.includes('pdf')) {
        return '<svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M360-460h40v-80h40q17 0 28.5-11.5T480-580v-40q0-17-11.5-28.5T440-660h-80v200Zm40-120v-40h40v40h-40Zm120 120h80q17 0 28.5-11.5T640-500v-120q0-17-11.5-28.5T600-660h-80v200Zm40-40v-120h40v120h-40Zm120 40h40v-80h40v-40h-40v-40h40v-40h-80v200ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"/></svg>';
      } else if(fileName.includes('word')) {
        return '<svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M320-440h320v-80H320v80Zm0 120h320v-80H320v80Zm0 120h200v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>';
      } else {
        return '<svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="30px" fill="black"><path d="M240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>';
      }
    };

    const dataTransferCall = () => {
      const dataTransfer = new DataTransfer();
      evnt.target.filesContainer.forEach(subFileInfo => {
        if(subFileInfo !== undefined)
          dataTransfer.items.add(subFileInfo);
      });
      evnt.target.files = dataTransfer.files;
    };
    
    const removeNodeCall = (groupFileId) => {
      delete evnt.target.filesContainer[groupFileId];
      dataTransferCall();
      fileNode.remove();
    };

    const fileNode = document.createElement("li");
    fileNode.dataset.groupFileId = evnt.target.filesContainer.length-1;
    fileNode.innerHTML+= `
      ${getIconFile(fileInfo.type)}
      ${fileInfo.name.length >= 30 ? fileInfo.name.substr(0, 30) + '...' : fileInfo.name}
    `;

    const removeNode = document.createElement("i");
    removeNode.onclick = () => removeNodeCall(fileNode.dataset.groupFileId);
    removeNode.innerHTML =  `
      <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#ec7063">
        <path d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z"/>
      </svg>
    `;

    fileNode.append(removeNode);
    evnt.target.parentNode.nextElementSibling.append(fileNode);
    dataTransferCall();

  }
};
