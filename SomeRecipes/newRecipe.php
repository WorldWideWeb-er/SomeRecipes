<?php
//Upload File once everything clears
function uploadRecipeImg($imageID){
		$file = $_FILES['file'];

		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if(in_array($fileActualExt,$allowed)){
			if($fileError === 0){
				if($fileSize < 500000){
					//Now we can upload
					$fileNameNew = $imageID."_recipeImg.".$fileActualExt;
					$fileDestination = "inc/recipe_Img/". $fileNameNew;
					move_uploaded_file($fileTmpName,$fileDestination);
					//Completed
					echo('Completed');
				}else{
					echo('File size too big!');
				}
			}else{
				echo("Cannot allow this type of file");
			}
		}else{
			//Cannot allow this type
			echo("Cannot allow this type of file");
		}
	}
?>

<!doctype html>
<html>
<head>
  <title>SomeRecipies.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	function createNewRecipe(){
		let newRecipe = {
			id:"3",
			"name":"",
			"submitter":"",
			"summary":"",
			"reviewRating":"5",
			"imageInfo":{
				"image":"recipeImg",
				"imageAlt":""
			},
			"serves":"",
			"preparationTime":"",
			"cooking":"",
			"ingredients":{
				},
			"directions":{
			}
		}
		
		//Start Function
		//Globals
		console.log(newRecipe);
		let validationChecker = true;
		
		//Entry Validation
		//Name
		if (!document.querySelector("#name").value){
				document.querySelector("#invalid-Name-Input").innerHTML = "Please fill out this field.";
				validationChecker = false
			}else{
				document.querySelector("#invalid-Name-Input").innerHTML = "";
				newRecipe.name = document.querySelector("#name").value;
				newRecipe.imageInfo.imageAlt = document.querySelector("#name").value;
			}//End Name
		//Summary
		if (!document.querySelector("#summary").value){
				document.querySelector("#invalid-Summary-Input").innerHTML = "Please fill out this field.";
				validationChecker = false
			}else{
				document.querySelector("#invalid-Summary-Input").innerHTML = "";
				newRecipe.summary = document.querySelector("#summary").value;
			}//End Preparation
		//Submitters Name
		if (!document.querySelector("#submitter").value){
				document.querySelector("#invalid-Submitters-Input").innerHTML = "Please fill out this field.";
				validationChecker = false
			}else{
				document.querySelector("#invalid-Submitters-Input").innerHTML = "";
				newRecipe.submitter = document.querySelector("#submitter").value;
			}//End Submitters
		//Serves
		if (document.querySelector("#serves").value == 0){
				document.querySelector("#invalid-Serves-Input").innerHTML = "Please fill out this field.";
				validationChecker = false
			}else{
				document.querySelector("#invalid-Serves-Input").innerHTML = "";
				newRecipe.serves = document.querySelector("#serves").value;
			}//End Serves
		//Cooking Time
		if (!document.querySelector("#cookingNumber").value){
				document.querySelector("#invalid-Cooking-Input").innerHTML = "Please fill out this field.";
				validationChecker = false
			}else{
				document.querySelector("#invalid-Cooking-Input").innerHTML = "";
				if(document.querySelector("#cookingTime").value == 'Minutes'){
					newRecipe.cooking = document.querySelector("#cookingNumber").value + " " + document.querySelector("#cookingTime").value
				}else{
					if(document.querySelector("#cookingNumber").value == 1){
						newRecipe.cooking = document.querySelector("#cookingNumber").value + " " + document.querySelector("#cookingTime").value
					}else{
						newRecipe.cooking = document.querySelector("#cookingNumber").value + " Hours";
					}
				}
			}//End Cooking
		//Preparation
		if (!document.querySelector("#preparationNumber").value){
				document.querySelector("#invalid-Preparation-Input").innerHTML = "Please fill out this field.";
				validationChecker = false;
			}else{
				document.querySelector("#invalid-Preparation-Input").innerHTML = "";
				if(document.querySelector("#preparationNumber").value == 1){
					newRecipe.preparationTime = document.querySelector("#preparationNumber").value + " " + document.querySelector("#preparationTime").value
				}else{
					newRecipe.preparationTime = document.querySelector("#preparationNumber").value + " Hours";
				}
				;
			}//End Preparation
		
		//Entering Ingredents to Javascript Object
		ingredientInputCounter = 0;
		while(document.querySelector("#quantityNumber"+ingredientInputCounter) != null ){
			if (!document.querySelector("#quantityNumber"+ingredientInputCounter).value){
				document.querySelector("#invalid-ingredient"+ingredientInputCounter+"-Input").innerHTML = "Please fill out this field.";
			}else{
				let singleIngArray = [];
				let ingQuantityNumb = document.querySelector("#quantityNumber"+ingredientInputCounter).value
				singleIngArray.push(ingQuantityNumb)
				let ingQuantitySize = document.querySelector("#quantitySize"+ingredientInputCounter).value
				let ingName = document.querySelector("#ingName"+ingredientInputCounter).value
				singleIngArray.push(ingQuantitySize + " " + ingName )
				newRecipe.ingredients[ingredientInputCounter] = singleIngArray
			}
			ingredientInputCounter++
		}	
		
		//Entering Directions to Javascript Object
		directionInputCounter = 0;
		while(document.querySelector("#step"+directionInputCounter) != null ){
			if (!document.querySelector("#step"+directionInputCounter).value){
				document.querySelector("#invalid-direction"+directionInputCounter+"-Input").innerHTML = "Please fill out this field.";
			}else{
				let singleDirectionArray = [];
				let singleDirection = document.querySelector("#step"+directionInputCounter).value
				newRecipe.directions[directionInputCounter] = singleDirection
			}
			directionInputCounter++
		}	
		
		if(validationChecker){
			//saveRecipe(newRecipe['id'])
			console.log('test')
			completedRecipe = JSON.stringify(newRecipe)
			window.localStorage.setItem("newRecipe",completedRecipe);
			
			
			
			//Direct to View Recipe Page
			window.localStorage.setItem("selectedRecipe",newRecipe['id']);
			location.href = 'viewRecipe.html';
		}
		
		
	}
	
	let ingredientCount = 2//Starting counter at two 
	function addIngredient(){
		let newIngredient = document.createElement("div");
			newIngredient.setAttribute("class","input-group mb-3");
			let spanTag = document.createElement("span");
				spanTag.setAttribute("class","input-group-text");
				spanTag.innerHTML = "Quantity";	
				newIngredient.appendChild(spanTag);
			let inputNumber = document.createElement("input");
				inputNumber.setAttribute("type","text");
				inputNumber.setAttribute("class","form-control");
				inputNumber.setAttribute("id","quantityNumber" + ingredientCount);
				inputNumber.setAttribute("name","quantityNumber" + ingredientCount);
				inputNumber.setAttribute("placeholder","Ex: 1, 3, 1/4");
				newIngredient.appendChild(inputNumber);
			let inputSize = document.createElement("input");
				inputSize.setAttribute("type","text");
				inputSize.setAttribute("class","form-control");
				inputSize.setAttribute("id","quantitySize" + ingredientCount);
				inputSize.setAttribute("name","quantitySize" + ingredientCount);
				inputSize.setAttribute("placeholder","Ex: Cup, Quart, Box");
				newIngredient.appendChild(inputSize);
			let spacer = document.createTextNode('\u00A0');
				newIngredient.appendChild(spacer);
			let spanTagName = document.createElement("span");
				spanTagName.setAttribute("class","input-group-text");
				spanTagName.innerHTML = "Ingredient Name";	
				newIngredient.appendChild(spanTagName);
			let inputIng = document.createElement("input");
				inputIng.setAttribute("type","text");
				inputIng.setAttribute("class","form-control");
				inputIng.setAttribute("id","ingName" + ingredientCount);
				inputIng.setAttribute("name","ingName" + ingredientCount);
				inputIng.setAttribute("placeholder","Ex: Pasta Sause, Can of Beans");
				newIngredient.appendChild(inputIng);
		let spanInvalid = document.createElement("span");
			spanInvalid.setAttribute("id","invalid-ingredient"+ingredientCount+"-Input");	
		
		document.querySelector("#newIngredientEntry").appendChild(newIngredient);
		document.querySelector("#newIngredientEntry").appendChild(spanInvalid);
		ingredientCount++;
	}
			
	let directionCount = 2//Starting counter at two 
	function addDirection(){
		let newDirection = document.createElement("div");
			newDirection.setAttribute("class","input-group mb-3");
			let spanTag = document.createElement("span");
				spanTag.setAttribute("class","input-group-text");
				spanTag.innerHTML = "Step " + (directionCount +1);	
				newDirection.appendChild(spanTag);
			let inputStep = document.createElement("textarea");
				inputStep.setAttribute("class","form-control");
				inputStep.setAttribute("rows","1");
				inputStep.setAttribute("id","step" + directionCount);
				inputStep.setAttribute("name","step" + directionCount);
				newDirection.appendChild(inputStep);
			
		let spanInvalid = document.createElement("span");
			spanInvalid.setAttribute("id","invalid-direction"+directionCount+"-Input");	
		
		document.querySelector("#newDirectionEntry").appendChild(newDirection);
		document.querySelector("#newDirectionEntry").appendChild(spanInvalid);
		directionCount++;
	}
	
</script>
</head>

<body>
<div class="container-fluid p-2" style="background-color: #F2F2F2">
</div>
<div class="container-fluid p-5" style="background-color: #F2F2F2">
</div>

	<!--- Navigation --->
	<nav class="navbar navbar-expand-sm navbar-dark sticky-top" style="background-color: #FFFFFF; border-top: 1px solid #DAD8D6;">
		<div class="container">
			<div class="container-fluid">
				<div class="row"  style="display: flex; align-items: baseline">
					<div class="col-1">
						<div style="display: flex; align-items: baseline" >
							<img src="inc/icons/card-text.svg" alt="popUp">
							<p style="padding: 0px 0px 0px 8px">Explore</p>
						</div>
					</div>
					<div class="col" style="display: flex; align-items: baseline">
						<div>
							<a href="index.html" style=" text-decoration: none;"><h3 style="padding: 0px 0px 0px 12px; color: #D54215; text-decoration: none;">SomeRecipes</h3></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<!--- Search Header -->
	<div class="container-fluid" style="background-color: #F5F6EA; height: 150px; border-bottom: ">
		<div class="container">
			<div class="row">
				<div class="col-4 pt-3">
					<form action="/action_page.php">
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Search" name="search">
							<span class="input-group-text" style="background-color: #D54215"><img src="inc/icons/search.svg" alt="searchIcon"></span>
						</div>
					</form>
				</div>
				<div class="col-1"></div>
				<div class="col-7 pt-4">
				</div>
			</div>
		</div>
	</div>
	
	<!--- Main Content --->
	<div class="container pt-3" style="border-left: 2px solid #D54215; border-right: 2px solid #D54215">
	<div class="row">
		<div class="col-2">
		</div>	
		<div class="col-8">
			<h2>New Recipe</h2>
			<hr style="border-top: 3px solid #929191; width: 100%">		
			<form action="">
				<div class="row">
					<div class="col-6" >
						<div style="height: 250px">
							<img id="frame" src="null" class="img-fluid" alt="Image Preview" style="height: 250px; max-width: 500px"/>
						</div>
						<div class="mb-5" >
							<label for="Image" class="form-label">Picture of Dish</label>
							<input class="form-control" type="file" name="file" id="recipeImg" onchange="preview()">
						</div>
					<script>
						function preview() {
							frame.src = URL.createObjectURL(event.target.files[0]);
						}
					</script>
					</div>
					<div class="col-6">
						<div class="mb-3 mt-3">
							<label for="name" class="form-label">Name of Dish:</label>
							<input type="text" class="form-control" placeholder="Dish Name" id="name" name="name">
							<span id="invalid-Name-Input"></span>
						</div>
						<div class="mb-3 mt-3">
							<label for="summary" class="form-label">Breif Description of Dish</label>
							<textarea class="form-control" rows="5" name="text" id="summary" name="summary"></textarea>
							<span id="invalid-Summary-Input"></span>
						</div>
						
					</div>
					<div style="display: flex;justify-content: space-between">
						<div class="col-6">
							<div class="mb-3">
							<label for="submitter" class="form-label">Submitters Name:</label>
							<input type="text" class="form-control" placeholder="Submitters Name" id="submitter" name="submitter">
							<span id="invalid-Submitters-Input"></span>
						</div>
						<div class="mb-3">
							<label for="serves" class="form-label">Dish Serves:</label>
							<select class="form-select"  id="serves" name="serves">
								<option value="0">Serves...</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="10+">10+</option>
							</select>
							<span id="invalid-Serves-Input"></span>
						</div>
						
						</div>
						<div class="col-6">
							<div class="mb-3">		
								<label for="preparationTime" class="form-label">Preparation Time:</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="Time" id="preparationNumber" name="preparationNumber">
									<select class="form-select" id="preparationTime" name="preparationTime">
										<option value="Minutes">Minutes</option>
										<option value="Hour">Hours</option>
									</select>
								</div> 
								<span id="invalid-Preparation-Input"></span>
							</div>	
							<div class="mb-3">		
								<label for="cookingTime" class="form-label">Cooking / Baking Time:</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="Time" id="cookingNumber" name="cookingNumber">
									<select class="form-select" id="cookingTime" name="cookingTime">
										<option value="Minutes">Minutes</option>
										<option value="Hour">Hours</option>
									</select>
								</div> 
								<span id="invalid-Cooking-Input"></span>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div style="display: flex; align-items:center">
						<hr style="border-top: 3px solid #929191; width: 100%">		
					</div>
					<h3>Ingredients</h3>
						<div id="newIngredientEntry">
							<div class="input-group mb-3">
								<span class="input-group-text">Quantity</span>
								<input type="text" class="form-control" id="quantityNumber0" name="quantityNumber0" placeholder="Ex: 1, 3, 1/4">
								<input type="text" class="form-control" id="quantitySize0" name="quantitySize0" placeholder="Ex: Cup, Quart, Box">
								&nbsp;
								<span class="input-group-text">Ingredient Name</span>
								<input type="text" class="form-control" id="ingName0" name="ingName0" placeholder="Ex: Pasta Sause, Can of Beans">
							</div>
							<span id="invalid-ingredient0-Input"></span>
							<div class="input-group mb-3">
								<span class="input-group-text">Quantity</span>
								<input type="text" class="form-control" id="quantityNumber1" name="quantityNumber1" placeholder="Ex: 1, 3, 1/4">
								<input type="text" class="form-control" id="quantitySize1" name="quantitySize1" placeholder="Ex: Cup, Quart, Box">
								&nbsp;
								<span class="input-group-text">Ingredient Name</span>
								<input type="text" class="form-control" id="ingName1" name="ingName1" placeholder="Ex: Pasta Sause, Can of Beans">
							</div>
							<span id="invalid-ingredient1-Input"></span>
						</div>
						<p>
							<label for="addIngredient"></label>
							<input type="button" class="btn btn" style="background-color: #D54215" onclick="addIngredient()" value=" Add Another Ingredient">
						</p>

					
					
					<div style="display: flex; align-items:center">
						<hr style="border-top: 3px solid #929191; width: 100%">		
					</div>
					<h3>Directions</h3>
						<div id="newDirectionEntry">
							<div class="input-group mb-3">
								<span class="input-group-text">Step 1</span>
								<textarea class="form-control" rows="1" id="step0" name="step0"></textarea>
							</div>
							<span id="invalid-direction0-Input"></span>
							<div class="input-group mb-3">
								<span class="input-group-text">Step 2</span>
								<textarea class="form-control" rows="1" id="step1" name="step1"></textarea>
							</div>
							<span id="invalid-direction1-Input"></span>
						</div>
						<p>
							<label for="addIngredient"></label>
							<input type="submit" class="btn btn" style="background-color: #D54215" onclick="addDirection()" value=" Add Another Step">
						</p>
					
					
					
					<div style="display: flex; align-items:center">
						<hr style="border-top: 3px solid #929191; width: 100%">		
					</div>
				</div>
				<button type="button" class="btn btn" style="background-color: #D54215" id="button" name="button" onClick="createNewRecipe();">Save</button>
			</form>
		</div>	
		<div class="col-2">
		</div>
		</div>
	</div>	
</body>
</html>
