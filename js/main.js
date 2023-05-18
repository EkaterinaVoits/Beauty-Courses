/*------------Авторизация-----------*/

$('.login-btn').click(function(e)  {

	e.preventDefault();
	$(`input`).removeClass('error-input');

	let email = $('input[name="email"]').val(),
		password = $('input[name="password"]').val();

	$.ajax({
		url:'authorization_handler.php',
		type:'POST',
		dataType:'json',
		data: {
			email:email,
			password:password
		},
		success (data) { 

			if(data.status) {
				document.location.href='/index.php';
			} else {

				if(data.type===1){
					data.fields.forEach(function(field){
					$(`input[name="${field}"]`).addClass('error-input');
					});
				}

				$(`span[name="email-error-span"]`).removeClass('none').text(data.emailError);
				$(`span[name="password-error-span"]`).removeClass('none').text(data.passwordError);

			}
		}
	});
});


/*----Получение аватарки с поля----*/

let photo=false;

$('input[name="photo"]').change(function(e)  {
	photo=e.target.files[0]; 
});



/*------------Регистрация-----------*/

//$(".tel_input").mask("+375 (99) 999-99-99");

$('.reg-btn').click(function(e)  {

	e.preventDefault();
	$(`input`).removeClass('error-input');
	
	let name = $('input[name="name"]').val(),
		email = $('input[name="email"]').val(),
		telephone = $('input[name="telephone"]').val(),
		password = $('input[name="password"]').val(),
		password_confirm = $('input[name="password_confirm"]').val();

	let formData=new FormData();
	formData.append('email', email);
	formData.append('name', name);
	formData.append('telephone', telephone);
	formData.append('password', password);
	formData.append('password_confirm', password_confirm);
	formData.append('photo', photo);

	$.ajax({
		url:'registration_handler.php',
		type:'POST',
		dataType:'json',
		processData: false,
		contentType: false,
		cache: false,
		data: formData,
		success (data) {

			if(data.status) {
				 document.location.href='/index.php';
			} else {

				if(data.type===1){
					data.fields.forEach(function(field){
					$(`input[name="${field}"]`).addClass('error-input');
					});
				}

				$(`span[name="name-error-span"]`).removeClass('none').text(data.nameError);
				$(`span[name="email-error-span"]`).removeClass('none').text(data.emailError);
				$(`span[name="telephone-error-span"]`).removeClass('none').text(data.telephoneError);
				$(`span[name="photo-error-span"]`).removeClass('none').text(data.photoError);
				$(`span[name="password-error-span"]`).removeClass('none').text(data.passwordError);
				$(`span[name="password_confirm-error-span"]`).removeClass('none').text(data.password_confirmError);


			}
		}
	});
});


/*------------Форма получения консультации-----------*/

$('.take-consult-btn').click(function(e) {

	e.preventDefault();
	
	let user_name = $('input[name="user_name_consult"]').val(),
		user_telephone = $('input[name="user_telephone_consult"]').val();

	$.ajax({
		url:'modules/pages_handlers/consult_handler.php',
		type:'POST',
		data: {
			user_name: user_name,
			user_telephone: user_telephone
		},
		success (data) {
			alert("Заявка отправлена! Мы свяжемся с вами в ближайшее время");
			document.getElementById("user_name_consult").value="";
			document.getElementById("user_telephone_consult").value="";
		}
	});

});


/*------------Переход на страницу поста-----------*/

function showCourse(id){
	
	let this_id=id;
	console.log(this_id)

	$.ajax({
		url:'modules/pages_handlers/course_handler.php',
		type:'GET',
		dataType:'json',
		data: {
			id: this_id
		},
		success (data) {
			document.location.href='/course.php?id='+data;
		}
	});

}


/*------------Добавление комментария-----------*/

$('.add-review-btn').click(function(e) {

	e.preventDefault();
	
	let user_review = $('textarea[name="review-textarea"]').val();

	$.ajax({
		url:'modules/pages_handlers/comment_handler.php',
		type:'POST',
		data: {
			review:user_review
		},
		success (data) {
			document.getElementById("review-textarea").value="";
			$("#results_reviews").html(data);
		}
	});


});

 
/*------------Получение значений фильтров-----------*/

$(document).on('click', '.all-checkboxes', function(){

	let masters_id=[],
		groups_type=[];

	let sort_type=document.getElementById('sorting').value="";

	$('.masters-ckbx:checked').each(function(key){
		masters_id[key]=$(this).val();
	});

	$('.groups-ckbx:checked').each(function(key){
		groups_type[key]=$(this).val();
	});

	$.ajax({
		url:'modules/pages_handlers/filter_handler.php',
		type:'POST',
		data: {
			masters_id:masters_id,
			groups_type:groups_type,
			sort_type:sort_type
		},
		success (data) {
			$(".courses").html(data);
		}
	});
});


/*------------Получение значения сортировки-----------*/

$("#sorting").on('change', function(){
	
	var value=$(this).val();

	let masters_id=[],
		groups_type=[];
	
	$('.masters-ckbx:checked').each(function(key){
		masters_id[key]=$(this).val();
	});

	$('.groups-ckbx:checked').each(function(key){
		groups_type[key]=$(this).val();
	});

	$.ajax({
		url:'modules/pages_handlers/filter_handler.php',
		type:'POST',
		data: {
			sort_request:value,
			masters_id:masters_id,
			groups_type:groups_type,
		},
		success (data) {
			$(".courses").html(data);

		}
	});
});


//----------------------Лайки------------------------

$('#likes').click(function (e) {

    e.preventDefault(); 
    
    $.ajax({
        url: 'modules/pages_handlers/likes_handler.php',
        type: 'POST',
        dataType: 'json',
        success(data) {
            $('#likes_count').text(data.count);
            document.getElementById('like').style.fill = data.fill;
        }
    });

});


//------------ Боковое меню на странице профиля ------------

$('.tab').on('click', function() {

	let tab_id=$(this).attr('id');

	let all_blocks=document.getElementsByClassName('block');
	let all_tabs=document.getElementsByClassName('tab');

	for(i=0; i<all_blocks.length; i++) {
		all_blocks[i].style.display='none';
		all_tabs[i].style.color='black';
		all_tabs[i].style.fontWeight = '400	';
	}

	let tab_element=document.getElementById(tab_id);
	tab_element.style.transition = '0.5s';
	tab_element.style.color='#bca1a1';
	tab_element.style.fontWeight = '600';
	tab_element.style.scale = '1.03';
	
	if(tab_id=='profile-tab') {
		document.getElementById('profile-block').style.display='block';
	} else if (tab_id=='user-courses-tab') {
		document.getElementById('user-courses-block').style.display='block';
	} else if (tab_id=='liked-courses-tab') {
		document.getElementById('liked-courses-block').style.display='block';
	} else if (tab_id=='registration-admin-tab') {
		document.getElementById('admin-registration-block').style.display='block';
	} else if (tab_id=='masters-admin-tab') {
		document.getElementById('admin-masters-block').style.display='block';
	} else if (tab_id=='org-courses-tab') {
		document.getElementById('admin-org-courses-block').style.display='block';
	} else if (tab_id=='courses-admin-tab') {
		document.getElementById('admin-courses-block').style.display='block';
	} else if (tab_id=='consult-admin-tab') {
		document.getElementById('admin-consult-block').style.display='block';
	}

});


//------------ Редактировать профиль на странице профиля ------------

//------Иконка "редактировать профиль"------
$('.edit-profile-btn').on('click', function() {
	document.getElementById('profile_content').style.display='none';
	document.getElementById('change_profile_content').style.display='block';
});

//------Кнопка "назад" из блока редактирования ------
$('.go-back-toProfile-btn').on('click', function() {
	document.getElementById('profile_content').style.display='block';
	document.getElementById('change_profile_content').style.display='none';
});

//------ Кнопка "изменить фото изображения" ------
$('#change-profile-img-btn').on('click', function() {
	document.getElementById('load_new_photo').style.display='block';
});

//-------- Редактировать профиль на странице профиля --------


/*----Получение аватарки с поля----*/

let new_user_photo=false;

$('input[name="new_profile_photo"]').change(function(e)  {
	new_user_photo=e.target.files[0]; 
});


$('.save_edit_changes').click(function(e)  {

	e.preventDefault();
	let user_email_beforeChanges=$(this).attr('id');

	$(`input`).removeClass('error-input');
	$(".error-span").addClass('none');
	
	let name = $('input[name="profile_name"]').val(),
		email = $('input[name="profile_email"]').val(),
		telephone = $('input[name="profile_telephone"]').val(),
		old_password = $('input[name="old_password"]').val(),
		new_password = $('input[name="new_password"]').val(),
		password_confirm = $('input[name="new_password_confirm"]').val();

	let userFormData=new FormData();
	userFormData.append('name', name);
	userFormData.append('user_email_beforeChanges', user_email_beforeChanges);
	userFormData.append('email', email);
	userFormData.append('telephone', telephone);
	userFormData.append('old_password', old_password);
	userFormData.append('new_password', new_password);
	userFormData.append('password_confirm', password_confirm);
	userFormData.append('new_user_photo', new_user_photo);

	$.ajax({
			url:'/modules/pages_handlers/edit_profile_handler.php',
			type:'POST',
			processData: false,
			contentType: false,
			cache: false,
			data: userFormData,
			dataType:'json',
			success (data) {
				if(data.status) {
					alert("Изменения сохранены");
					

					$("#profile-name1").text(data.new_name);
					$("#profile-telephone1").text(data.new_telephone);
					$("#profile-email1").text(data.new_email);

					document.getElementById("profile-img").src="../../img/"+data.new_photo;
					document.getElementById("profile-img2").src="../../img/"+data.new_photo;
					document.getElementById("new_profile_photo_input").value="";

					document.getElementById("old_password").value="";
					document.getElementById("new_password").value="";
					document.getElementById("new_password_confirm").value="";

					document.getElementById('profile_content').style.display='block';
					document.getElementById('change_profile_content').style.display='none';

				} else {

					if(data.type===1){

						alert("Изменения не были сохранены");

						data.fields.forEach(function(field){
						$(`input[name="${field}"]`).addClass('error-input');
						});

					}

					$(`span[name="profile_name-error-span"]`).removeClass('none').text(data.nameError);
					$(`span[name="profile_telephone-error-span"]`).removeClass('none').text(data.telephoneError);
					$(`span[name="profile_email-error-span"]`).removeClass('none').text(data.emailError);
					$(`span[name="old_password-error-span"]`).removeClass('none').text(data.oldPasswordError);
					$(`span[name="new_password-error-span"]`).removeClass('none').text(data.newPasswordError);
					$(`span[name="new_password_confirm-error-span"]`).removeClass('none').text(data.confirmPasswordError);

				}
			}
	});
});


/*------------Бронь курса на странице "Выбрать курс"-----------*/

//$('.reserve-btn').click(function(e) {
function reserve(id){

	let this_id=id;
	console.log(this_id);

	let answer=confirm("Вы уверены, что хотите подать заявку?");
	if(answer) {

		$.ajax({
			url:'modules/pages_handlers/reserve_handler.php',
			type:'POST',
			data: {
				id_org_course:this_id,
			},
			success (data) {
				alert("Заявка подана. Отменить запись можно в личном кабинете");
				$('.status-or-reserve-btn'+this_id).html(data);
			}
		});
	}
}


/*------------Отмена курса в профиле -----------*/

//$('.cancel-reg-btn').click(function(e) {
function cancelReg(id){

	let this_id=id;
	console.log(this_id);

	let answer=confirm("Вы уверены, что хотите отменить заявку?");
	if(answer) {

		$.ajax({
			url:'/modules/pages_handlers/user_delete_reg_handler.php',
			type:'POST',
			data: {
				reg_id: this_id
			},
			success (data) {
				$("#user-courses-block").html(data);
				alert("Запись отменена");
			}
		});
	}
}


/*------------Изменение статуса регистрации в админке-----------*/

$(".status_select").on('change', function(){
	
	let this_select_id=$(this).attr('id');
	console.log(this_select_id);
	var value=$(this).val();

	$.ajax({
		url:'/modules/pages_handlers/change_reg_status_handler.php',
		type:'POST',
		data: {
			reg_status:value,
			id_status_select:this_select_id
		},
		success (data) {
			$("#course_status"+this_select_id).html(data);
			//document.getElementById("this_select_id").value="";
			document.getElementsByClassName('status_select').value="no_status";
		}
	});
});


/*------------Удаление регистрации в админке-----------*/

$('.del-reg-btn').click(function(e) {

	let this_id=$(this).attr('id');
	console.log(this_id);

	let answer=confirm("Вы уверены, что удалить запись?");
	if(answer) {
			$.ajax({
			url:'/modules/pages_handlers/admin_delete_reg_handler.php',
			type:'POST',
			data: {
				reg_id: this_id
			},
			success (data) {

				$(".reg-body-table").html(data);
				alert("Запись удалена");
			}
		});
	}
});


/*------------Удаление мастера в админке-----------*/

//$('.del-master-btn').click(function(e) {
function deleteMaster(id){

	let this_id=id;
	console.log(this_id);

	let answer=confirm("Вы уверены, что удалить мастера?");
	if(answer) {
			$.ajax({
			url:'/modules/pages_handlers/admin_delete_master_handler.php',
			type:'POST',
			data: {
				master_id: this_id
			},
			success (data) {
				$(".masters-body-table").html(data);
			}
		});
	}
}


/*------------Удаление курса в админке-----------*/

//$('.del-master-btn').click(function(e) {
function deleteCourse(id){

	let this_id=id;
	console.log(this_id);

	let answer=confirm("Вы уверены, что удалить курс?");
	if(answer) {
			$.ajax({
			url:'/modules/pages_handlers/admin_delete_course_handler.php',
			type:'POST',
			
			data: {
				course_id: this_id
			},
			success (data) {
				$(".courses-body-table").html(data);
			}
		});
	}
}


/*------------Добавление регистрации на курс в админке-----------*/

$('#add_reg_btn').click(function(e) {

	e.preventDefault();

	let users_email = $('input[name="users-email"]').val();
	let id_orgCourse = $('select[name="org-course-select1"]').val();
	
	$.ajax({
		url:'/modules/pages_handlers/add_reg_handler.php',
		type:'POST',
		data: {
			users_email:users_email,
			id_orgCourse: id_orgCourse
		},
		success (data) {
			document.getElementById("users_email").value="";
			$(".reg-body-table").html(data);
		}
	});
});



/*------------Добавление мастера в админке-----------*/

//----получение фото----
let masters_photo=false;

$('input[name="masters_photo"]').change(function(e)  {
	masters_photo=e.target.files[0]; 
});


$('#add_master_btn').click(function(e) {

	e.preventDefault();
	
	let masters_name = $('input[name="masters-name"]').val();
	let masters_email = $('input[name="masters-email"]').val();
	let masters_telephone = $('input[name="masters-telephone"]').val();
	let masters_info = $('textarea[name="masters-info"]').val();

	let formDataMaster=new FormData();
	formDataMaster.append('masters_name', masters_name);
	formDataMaster.append('masters_email', masters_email);
	formDataMaster.append('masters_telephone', masters_telephone);
	formDataMaster.append('masters_info', masters_info);
	formDataMaster.append('masters_photo', masters_photo);
	
	$.ajax({
		url:'/modules/pages_handlers/add_master_handler.php',
		type:'POST',
		processData: false,
		contentType: false,
		cache: false,
		data: formDataMaster,
		success (data) {
			alert("Мастер добавлен");
			document.getElementById("masters_name").value="";
			document.getElementById("masters_email").value="";
			document.getElementById("masters_telephone").value="";
			document.getElementById("masters_info").value="";
			document.getElementById("masters_photo").value="";
			$(".masters-body-table").html(data);
		}
	});
});


/*------------Добавление орг.курса в админке-----------*/

$('#add_org_course_btn').click(function(e) {

	e.preventDefault();

	let course_id = $('select[name="course-select"]').val();
	let master_id = $('select[name="master-select"]').val();
	let course_startDate = $('input[name="course-startDate"]').val();
	let course_duration = $('input[name="course-duration"]').val();
	let course_groupType = $('select[name="course-groupType-select"]').val();
	let course_schedule = $('input[name="course-schedule"]').val();
	
	$.ajax({
		url:'/modules/pages_handlers/add_org_course_handler.php',
		type:'POST',
		data: {
			course_id:course_id,
			master_id:master_id,
			course_startDate:course_startDate,
			course_duration: course_duration,
			course_groupType:course_groupType,
			course_schedule:course_schedule	
		},
		success (data) {
			alert("Орг.курс добавлен");
			document.getElementById("course_startDate").value="";
			document.getElementById("course_duration").value="";
			document.getElementById("course_schedule").value="";
			
			$(".org-courses-body-table").html(data);
		}
	});
});


/*------------Изменение курса в админке-----------*/

function editCourse(id) {

	let course_id=id;

	let course_title = document.getElementById("title-course"+course_id).innerHTML;
	let course_description = document.getElementById("description-course"+course_id).innerHTML;
	let course_price = document.getElementById("price-course"+course_id).innerHTML;

	$.ajax({
		url:'/modules/pages_handlers/edit_course_handler.php',
		type:'POST',
		data: {
			course_id:course_id,
			course_title:course_title,
			course_description:course_description,
			course_price:course_price
		},
		success (data) {
			alert("Редактирование");
			$("#row"+course_id).html(data);
		}
	});
}

function saveChangesCourse(id) {

	let course_id=id;

	let new_course_title = $('textarea[name="new-course-title"]').val();
	let new_course_description = $('textarea[name="new-course-description"]').val();
	let new_course_price = $('input[name="new-course-price"]').val();

	$.ajax({
		url:'/modules/pages_handlers/saveChanges_course_handler.php',
		type:'POST',
		data: {
			course_id:course_id,
			new_course_title:new_course_title,
			new_course_description:new_course_description,
			new_course_price:new_course_price
		},
		success (data) {
			alert("Сохранение");
			$("#row"+course_id).html(data);
		}
	});
}


/*------------Изменение статуса консультации в админке-----------*/

$(".status_select2").on('change', function(){
	
	let this_select_id=$(this).attr('id');
	console.log(this_select_id);
	var value=$(this).val();

	$.ajax({
		url:'/modules/pages_handlers/change_consult_status_handler.php',
		type:'POST',
		data: {
			consult_status:value,
			id_status_select:this_select_id
		},
		success (data) {
			$("#consult_status"+this_select_id).html(data);
			
			document.getElementsByClassName('status_select2').value="no_status";
		}
	});
});
