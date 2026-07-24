document.addEventListener("DOMContentLoaded", function(){


    // Auto hide alerts after 5 seconds

    const alerts = document.querySelectorAll(".alert");


    alerts.forEach(function(alert){

        setTimeout(function(){

            alert.style.display = "none";

        },5000);

    });





    // Delete confirmation

    const deleteButtons = document.querySelectorAll(
        ".btn-danger"
    );


    deleteButtons.forEach(function(button){


        if(button.getAttribute("onclick") === null)
        {

            button.addEventListener(
                "click",
                function(event){

                    let confirmDelete = confirm(
                        "Are you sure you want to delete this item?"
                    );


                    if(!confirmDelete)
                    {
                        event.preventDefault();
                    }


                }
            );

        }


    });






    // Password visibility toggle


    const passwordFields = document.querySelectorAll(
        "input[type='password']"
    );


    passwordFields.forEach(function(field){


        let button = document.createElement("button");

        button.type="button";

        button.className="btn btn-info";

        button.style.marginTop="10px";

        button.innerHTML="Show Password";



        field.parentNode.appendChild(button);



        button.addEventListener(
            "click",
            function(){


                if(field.type==="password")
                {

                    field.type="text";

                    button.innerHTML="Hide Password";

                }
                else
                {

                    field.type="password";

                    button.innerHTML="Show Password";

                }


            }
        );


    });






    // Confirm form submission


    const forms = document.querySelectorAll("form");


    forms.forEach(function(form){


        form.addEventListener(
            "submit",
            function(){

                let buttons =
                form.querySelectorAll("button[type='submit']");


                buttons.forEach(function(button){

                    button.disabled=true;

                    button.innerHTML="Processing...";

                });


            }
        );


    });







    // Table search helper


    const searchInput =
    document.getElementById("tableSearch");



    if(searchInput)
    {

        searchInput.addEventListener(
            "keyup",
            function(){


                let value =
                searchInput.value.toLowerCase();



                let rows =
                document.querySelectorAll(
                    "table tbody tr"
                );



                rows.forEach(function(row){


                    let text =
                    row.innerText.toLowerCase();



                    if(text.includes(value))
                    {

                        row.style.display="";

                    }
                    else
                    {

                        row.style.display="none";

                    }



                });


            }
        );


    }





});
