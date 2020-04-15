function loadRepos(){
    var xhttp = new XMLHttpRequest();
    var groupid = document.getElementById("repoGroup").value;
    var x = document.getElementById("repoGroup").value;

    var total = 0;
    var totalworld = 0;
    
    xhttp.onreadystatechange = function(){
        if (this.readyState === 4 && this.status === 200){
            var text = '{ "repos" : ' + xhttp.responseText + '}';
            var obj = JSON.parse(text);

            var stageHTML = "";
            var appendText;
            var i;
            var sum = 0;
            
            //console.log(groupid)
            //console.log(obj.repos.Countries.length)
            //console.log(obj.repos[(obj.repos.length)-1].Cases)
            
            for(i = 0; i < obj.repos.Countries.length; i+=1){
                //console.log(obj.repos[i])
                //console.log(obj.repos.Countries[i].Country)
                if(obj.repos.Countries[i].Country == groupid)
                {
                    //console.log(obj.repos.Countries[i].TotalConfirmed)
                    appendText = obj.repos.Countries[i].TotalConfirmed;
                }
                sum = sum + obj.repos.Countries[i].TotalConfirmed;
            }
            if(i==obj.repos.Countries.length && appendText==null)
            {
                appendText = "0";
            }
            total = appendText;
            totalworld = sum;
            stageHTML = stageHTML + appendText;
            document.getElementById("repos").innerHTML = stageHTML;
            document.getElementById("world").innerHTML = sum;
            var result = parseInt(stageHTML)/sum*100;
            totalworld = totalworld - total;
            
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            
            document.getElementById("percent").innerHTML = result.toFixed(4);
        }
    };
    
    function drawChart() {
      console.log("Country : "+groupid+" "+total)
      console.log("World : "+totalworld)
      var x = groupid;
      var data = google.visualization.arrayToDataTable([
      ['Place', 'Place per World'],
      [x,total],['World',totalworld]]);

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Covid - 19', 'width':550, 'height':400};

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
    console.log("https://api.covid19api.com/summary");
    xhttp.open("GET","https://api.covid19api.com/summary", true);
    xhttp.send();
}

function loadRepoGroups(){    
    var xhttp = new XMLHttpRequest();
    var group = document.getElementById("repoGroup");
    var groupID = document.getElementById("repoGroup").value;

    if (groupID !== null) {
        xhttp.onreadystatechange = function(){
            if (this.readyState === 4 && this.status === 200){
                var text = '{ "repo_group" : ' + xhttp.responseText + '}';
                var obj = JSON.parse(text);
                console.log(obj)
                //console.log(obj.repo_group.Countries[1].Country)

               var stageHTML = '<option value="0">' + "Choose Country"+ "</option>";
                var appendText;

                var i;
                for(i = 1; i < obj.repo_group.Countries.length; i+=1){
                    //console.log(obj.repo_group[i].Name)
                    appendText = "<option value=\"" + obj.repo_group.Countries[i].Country + "\">" + obj.repo_group.Countries[i].Country + "</option>";
                    stageHTML = stageHTML + appendText;
                }

                document.getElementById("repoGroup").innerHTML = stageHTML
            }
       };

        xhttp.open("GET","https://api.covid19api.com/summary", true);
        xhttp.send();
    }
    
}
