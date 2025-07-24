function changeCellValue(cellNode, inputType = 'text') {

  if(event.target.nodeName !== "TD") return;
  const lastValue  = cellNode.innerHTML;
  const rowId      = cellNode.parentNode.firstElementChild.getAttribute("rowid-value");
  const columnName = cellNode.parentNode.parentNode.firstElementChild.children[Array.from(cellNode.parentNode.children).indexOf(cellNode)].getAttribute("column-ref");

  if(inputType === 'text') {
    
    const inputNode = document.createElement("input");
    inputNode.type = "text";
    inputNode.maxLength = cellNode.dataset.maxlength;
    inputNode.value = lastValue;

    inputNode.onkeydown = (event) => {
      if(event.key === 'Enter') {
        if(lastValue !== inputNode.value) {
          updateCellValue(
            rowId,
            columnName,
            inputNode.value,
            () => { inputNode.onblur = null; cellNode.innerHTML = inputNode.value; },
            () => { alert("Ocurrió un error al actualizar el valor de la celda"); }
          );
        } else inputNode.blur();
      }
    };

    inputNode.onblur = (event) => {
      if(event.relatedTarget?.nodeType !== "INPUT") {
        cellNode.innerHTML = lastValue;
      }
    };

    cellNode.innerHTML = null;
    cellNode.append(inputNode);
    inputNode.focus();

  } else if(inputType === 'schedule') {

    const inputWeekday = document.createElement("select");
    inputWeekday.innerHTML = `
      <option value="1" ${cellNode.getAttribute('weekday-value') == 1 ?  'selected' : String()}>Lunes</option>
      <option value="2" ${cellNode.getAttribute('weekday-value') == 2 ?  'selected' : String()}>Martes</option>
      <option value="3" ${cellNode.getAttribute('weekday-value') == 3 ?  'selected' : String()}>Miercoles</option>
      <option value="4" ${cellNode.getAttribute('weekday-value') == 4 ?  'selected' : String()}>Jueves</option>
      <option value="5" ${cellNode.getAttribute('weekday-value') == 5 ?  'selected' : String()}>Viernes</option>
      <option value="6" ${cellNode.getAttribute('weekday-value') == 6 ?  'selected' : String()}>Sabado</option>
    `;

    const inputStartTime = document.createElement("input");
    inputStartTime.type = "time";
    inputStartTime.value = cellNode.getAttribute("starttime-value");

    const inputEndTime = document.createElement("input");
    inputEndTime.type = "time";
    inputEndTime.value = cellNode.getAttribute("endtime-value");

    cellNode.onrequest = () => {
      const updateValue = `${inputWeekday.value}@${inputStartTime.value}-${inputEndTime.value}`;
      if(updateValue !== `${cellNode.getAttribute('weekday-value')}@${cellNode.getAttribute('starttime-value')}-${cellNode.getAttribute('endtime-value')}`) {
        updateCellValue(
          rowId,
          columnName,
          updateValue,
          () => {
            cellNode.setAttribute("weekday-value", inputWeekday.value);
            cellNode.setAttribute("starttime-value", inputStartTime.value);
            cellNode.setAttribute("endtime-value", inputEndTime.value);
            cellNode.innerHTML = `
              ${['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'][Number(inputWeekday.value)-1]}
              <br>de ${inputStartTime.value} a ${inputEndTime.value}
            `;
          },
          () => alert("Ocurrió un error al actualizar el valor de la celda")
        );
      } else cellNode.onclose();
    };

    cellNode.onclose = () => {
      cellNode.innerHTML = lastValue;
    };
    
    cellNode.innerHTML = null;
    cellNode.append(inputWeekday);
    cellNode.append(inputStartTime);
    cellNode.append(inputEndTime);

    Array.from(`<div>
      <br>
      <svg onclick="this.parentNode.onclose()" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f1948a"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
      <span>&nbsp;</span>
      <span>&nbsp;</span>
      <span>&nbsp;</span>
      <span>&nbsp;</span>
      <svg onclick="this.parentNode.onrequest()" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#58d68d"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160v212q-19-8-39.5-10.5t-40.5.5v-169L647-760H200v560h240v80H200Zm0-640v560-560ZM520-40v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-260L643-40H520Zm300-263-37-37 37 37ZM580-100h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19ZM240-560h360v-160H240v160Zm240 320h4l116-115v-5q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/></svg>
    </div>`.strToElement().children).forEach(element => cellNode.append(element));

  } else if(inputType === 'contextmenu-text') {

    event.preventDefault();
    if(cellNode.getAttribute("toggle") === null) {
      
      const buttonNode = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f1948a"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>'.strToElement();
      
      buttonNode.oncontextmenu = (event) => {
        event.preventDefault();
      };

      buttonNode.onclick = () => {
        if(confirm("¿Quieres borrar el registro?")) {
          deleteTableRow(
            rowId,
            () => cellNode.parentNode.remove(),
            () => alert("Ocurrió un error al eliminar la fila")
          );
        }
      };

      cellNode.innerHTML = null;
      cellNode.append(buttonNode);
      cellNode.setAttribute("toggle", null);

    } else {
      cellNode.innerHTML = cellNode.getAttribute("cell-value");
      cellNode.removeAttribute("toggle");
    }

  }
}

function updateCellValue(rowId, columnName, value, successCall = ()=>{}, errorCall=()=>{}) {

  const bodyRequest = new FormData();
  bodyRequest.append("action", "update");
  bodyRequest.append("id", rowId);
  bodyRequest.append("column", columnName);
  bodyRequest.append("text", value);

  fetch('/ajax/admin/modals/catalog.php', { method: "POST", body: bodyRequest })
    .then(res => {
      if(res.ok) {
        successCall();
      } else errorCall();
    })
  ;

}

function deleteTableRow(rowId, successCall = ()=>{}, errorCall=()=>{}) {
  
  const bodyRequest = new FormData();
  bodyRequest.append("action", "delete");
  bodyRequest.append("id", rowId);

  fetch('/ajax/admin/modals/catalog.php', { method: "POST", body: bodyRequest })
    .then(res => {
      if(res.ok) {
        successCall();
      } else errorCall();
    })
  ;

}
