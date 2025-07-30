var CURRENT_SCHEDULE_DATA;

/*<><><><><><><><><><>*/

function setSubjectSchedule(optionNode) {

  const detailsNode = optionNode.parentNode.parentNode.parentNode.lastElementChild;
  const hoursCountNode = detailsNode.parentNode.parentNode.parentNode.firstElementChild.querySelector("span");

  const convertToMinutes = (hour) => {
    if(hour) {
      const [hours, minutes] = hour.split(':').map(Number);
      return hours * 60 + minutes;
    }
  };

  /*..........*/

  if(optionNode.value === 'Limpiar') {

    hoursCountNode.textContent = "0 horas";
    hoursCountNode.removeAttribute("style");

    Array.from(optionNode.parentNode.options).forEach(optionNode => {
      optionNode.selected = false;
      detailsNode.innerHTML = "<b>MONITORIAS</b><br>";
    });

  } else {
    let currentMinutes = 0;
    Array.from(optionNode.parentNode.options).slice(1).forEach(optionNode => {
      const optionTimeValue = optionNode.value.split('@')[1].split('-');
      
      if(optionNode.selected)
        currentMinutes+= (convertToMinutes(optionTimeValue[1]) - convertToMinutes(optionTimeValue[0]));
      
      hoursCountNode.textContent = (parseFloat(currentMinutes)/60).toFixed(2) + ' horas';

      if(Number(currentMinutes) > 480) {
        hoursCountNode.style.background = "#FF6467";
      } else hoursCountNode.removeAttribute("style");
    });
  }

  /*..........*/

  Array.from(optionNode.parentNode.options).forEach(optionNode => {
    if(optionNode.value !== 'Limpiar') {

      if(Array.from(optionNode.parentNode.selectedOptions).includes(optionNode)) {

        const weekdayValue = optionNode.value.split('@')[0];
        const timeValue = optionNode.value.split('@')[1].split('-');

        const targetCellNode = document.getElementById(`${weekdayValue}@${timeValue[0].substr(0, 2)}`);
        targetCellNode.innerHTML = `
          <div class="subjectbox" style="height:${((Number(timeValue[1].substr(0, 2)) - Number(timeValue[0].substr(0, 2)))*25) + (Number(timeValue[1].substr(3, 5))*(25/59)) - (Number(timeValue[0].substr(3, 5))*(25/59) || 5) + 5}px;top:${(Number(timeValue[0].substr(3, 5))*(25/59) || 5) - 5}px">
            <u>MONITORIA</u>
            ${optionNode.dataset.subjectCode}
            <br>
            ${timeValue.join(' a ')}
          </div>
        `;

        if(CURRENT_SCHEDULE_DATA) {
          if(CURRENT_SCHEDULE_DATA[weekdayValue]) {
            for(let index in CURRENT_SCHEDULE_DATA[weekdayValue]) {
              CURRENT_SCHEDULE_DATA[weekdayValue][index].forEach(itemTime => {
                itemTime = itemTime.split('-');
                if(
                  (convertToMinutes(timeValue[0]) < convertToMinutes(itemTime[1]))
                  &&
                  (convertToMinutes(timeValue[1]) > convertToMinutes(itemTime[0]))
                ) targetCellNode.firstElementChild.classList.toggle('superimposed');
              });
            }
          }
        }

        if(!detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`)) {
          detailsNode.innerHTML+= `
            <p style="margin-top:10px" data-subject-id="${optionNode.dataset.subjectId}">${optionNode.textContent}</p>
          `;
        }
        
      } else {

        const weekdayValue = optionNode.value.split('@')[0];
        const timeValue = optionNode.value.split('@')[1].split('-');
        const targetCellId = `${weekdayValue}@${timeValue[0].substr(0, 2)}`;

        if(document.getElementById(targetCellId).querySelector(".subjectbox"))
          document.getElementById(targetCellId).querySelector(".subjectbox").remove();
        if(detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`))
          detailsNode.querySelector(`p[data-subject-id='${optionNode.dataset.subjectId}']`).remove();

      }
    }
  });
  
}

/*<><><><><><><><><><>*/

function updateUserSchedule(selectNode, userId) {
  if(confirm('¿Quieres confirmar la acción?')) {
    const subjects = [];
    Array.from(selectNode.selectedOptions).forEach(optionNode => subjects.push(optionNode.dataset.subjectId));
    requestPopup(`/ajax/admin/assign-schedule.php?user=${userId}&subjects=${subjects.length > 0 ? subjects.join(',') : 'NULL'}`, {
      finallyCall: () => {
        selectNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector("button.close-button").click();
        document.querySelector("nav").children[3].click();
      }
    });
  }
}
