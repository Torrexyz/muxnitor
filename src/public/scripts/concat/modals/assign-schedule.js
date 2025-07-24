function setSubjectSchedule(optionNode) {

  const detailsNode = optionNode.parentNode.parentNode.parentNode.lastElementChild;

  if(optionNode.value === 'Limpiar') {
    Array.from(optionNode.parentNode.options).forEach(optionNode => {
      optionNode.selected = false;
      detailsNode.innerHTML = "<b>MONITORIAS</b><br>";
    });
  }

  Array.from(optionNode.parentNode.options).forEach(optionNode => {
    if(optionNode.value !== 'Limpiar') {
      if(Array.from(optionNode.parentNode.selectedOptions).includes(optionNode)) {

        const weekday = optionNode.value.split('@')[0];
        const time = optionNode.value.split('@')[1].split('-');

        const targetCellNode = document.getElementById(`${weekday}@${time[0].substr(0, 2)}`);
        targetCellNode.innerHTML = `
          <div class="subjectbox" style="height:${(Number(time[1].substr(0, 2)) - Number(time[0].substr(0, 2)))*25}px">
            <u>MONITORIA</u>
            ${optionNode.parentNode.options[optionNode.parentNode.selectedIndex].dataset.subjectCode}
            <br>
            ${time.join(' a ')}
          </div>
        `;

        if(!detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`)) {
          detailsNode.innerHTML+= `
            <p style="margin-top:10px" data-subject-id="${optionNode.dataset.subjectId}">${optionNode.textContent}</p>
          `;
        }

      } else {

        const weekday = optionNode.value.split('@')[0];
        const time = optionNode.value.split('@')[1].split('-');
        const targetCellId = `${weekday}@${time[0].substr(0, 2)}`;

        if(document.getElementById(targetCellId).querySelector(".subjectbox"))
          document.getElementById(targetCellId).querySelector(".subjectbox").remove();
        if(detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`))
          detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`).remove();
                
      }
    }
  });
  
}

function updateUserSchedule(selectNode, userId) {
  if(confirm('¿Quieres confirmar la acción?')) {
    const subjects = [];
    Array.from(selectNode.selectedOptions).forEach(optionNode => subjects.push(optionNode.dataset.subjectId));
    requestPopup(`/ajax/concat/modals/assign-schedule.php?user=${userId}&subjects=${subjects.length > 0 ? subjects.join(',') : 'NULL'}`, {
      finallyCall: () => {
        selectNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("button.close-button").click();
        document.querySelector("nav").children[3].click();
      }
    });
  }
}
