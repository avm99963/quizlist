window.addEventListener("load", function() {
  document.querySelector("#paste-area").addEventListener("paste", function(e) {
    var data = [];
    if (e && e.clipboardData && e.clipboardData.types && e.clipboardData.getData) {
      var types = e.clipboardData.types;
      if (((types instanceof DOMStringList) && types.contains("text/html")) || (types.indexOf && types.indexOf('text/html') !== -1)) {
        var pastedData = e.clipboardData.getData('text/html');
        var template = document.createElement("template");
        template.innerHTML = pastedData;
        var dom = template.content.cloneNode(true);
        var form = dom.querySelector(".questionflagsaveform");
        if (form !== null) {
          var questions = form.querySelectorAll(".que");
          questions.forEach(q => {
            if (q.classList.contains("multichoice")) {
              var rightanswer = q.querySelector(".rightanswer").innerHTML;
              var question = q.querySelector(".qtext").innerHTML;
              var answers = q.querySelectorAll(".answer > div");
              var question = {
                "question": question,
                "rightanswer": rightanswer,
                "answers": []
              };
              answers.forEach(a => {
                question.answers.push(a.innerHTML);
              });
              data.push(question);
            } else {
              console.warn("This question is not a multichoice!");
            }
          });
          document.querySelector("#info").value = JSON.stringify(data);
          document.querySelector("form").submit();
        } else {
          console.error("Couldn't find dom");
        }
      } else {
        console.error("The paste wasn't html");
      }
    } else {
      console.error("No paste detected");
    }
    e.stopPropagation();
    e.preventDefault();
  }, false);
});

