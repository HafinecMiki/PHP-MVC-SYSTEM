<?php

require('db/User.php');

require('db/ChatRooms.php');

$chat_object = new ChatRooms;

$chat_data = $chat_object->get_all_chat_data();

$user_object = new User;

$user_data = $user_object->get_user_all_data();

?>

<!DOCTYPE html>
<html>

<head>
	<style type="text/css">
		#wrapper {
			display: flex;
			flex-flow: column;
			height: 100%;
		}

		#remaining {
			flex-grow: 1;
		}

		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}

		#chat-room-frm {
			margin-top: 10px;
		}

		#messages_area {
			height: 400px;
			overflow-y: auto;
			background-color: #e6e6e6;
			padding: 8px;
		}

		.chat-card {
			position: relative;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			-ms-flex-direction: column;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 1px solid rgba(0, 0, 0, .125);
			border-radius: 0.25rem;
		}

		.justify-content-start {
			justify-content: flex-start !important;
		}

		.justify-content-end {
			display: flex;
			justify-content: flex-end !important;
		}

		.max-width-full {
			max-width: 100%;
		}

		.text-dark {
			color: #343a40 !important;
		}

		.alert-light {
			color: #818182;
			background-color: #fefefe;
			border-color: #fdfdfe;
		}

		.card-header {
			margin-left: 8px;
		}

		.chat-form-control {
			flex: 1 1 auto;
			z-index: 2;
			padding: 0.375rem 0.75rem;
			border: 1px solid #ced4da;
			border-radius: 0.25rem;
		}

		.chat-textarea {
			font-size: inherit;
		}

		.input-group-append {
			margin-left: -1px;
			display: flex;
		}

		.input-group {
			display: flex !important;
		}
	</style>
</head>

<body>
	<div class="container max-width-full">
		<div class="row">
			<?php

			$login_user_id = '';

			foreach ($_SESSION['user_data'] as $key => $value) {
				$login_user_id = $value['id'];
			?>
				<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
			<?php
			}
			?>
			<div class="col-lg-12">
				<div class="chat-card">
					<div class="card-header">
						<div class="row">
							<div class="col col-xs-6">
								<h3>Chat Room</h3>
							</div>
						</div>
					</div>
					<div class="card-body" id="messages_area">
						<?php
						foreach ($chat_data as $chat) {
							if (isset($_SESSION['user_data'][$chat['userid']])) {
								$from = 'Me';
								$row_class = 'row margin-right-none justify-content-start';
								$background_class = 'text-dark alert-light';
							} else {
								$from = $chat['user_name'];
								$row_class = 'row margin-right-none justify-content-end';
								$background_class = 'alert-success';
							}

							echo '
						<div class="' . $row_class . '">
							<div class="col-xs-6">
								<div class="shadow-sm alert ' . $background_class . '">
									<b>' . $from . ' - </b>' . $chat["msg"] . '
									<br />
									<div class="text-right">
										<small><i>' . $chat["created_on"] . '</i></small>
									</div>
								</div>
							</div>
						</div>
						';
						}
						?>
					</div>
				</div>

				<form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
					<div class="input-group mb-3">
						<textarea class="chat-form-control chat-textarea" id="chat_message" name="chat_message" placeholder="Type Message Here" required></textarea>
						<div class="input-group-append">
							<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div>
					</div>
					<div id="validation_error"></div>
				</form>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var conn = new WebSocket('ws://localhost:8080');
	conn.onopen = function(e) {
		console.log("Connection established!");
	};

	conn.onmessage = function(e) {
		console.log(e.data);

		var data = JSON.parse(e.data);

		var row_class = '';

		var background_class = '';

		if (data.from == 'Me') {
			row_class = 'row justify-content-start';
			background_class = 'text-dark alert-light';
		} else {
			row_class = 'row justify-content-end';
			background_class = 'alert-success';
		}

		var html_data = "<div class='" + row_class + "'><div class='col-sm-10'><div class='shadow-sm alert " + background_class + "'><b>" + data.from + " - </b>" + data.msg + "<br /><div class='text-right'><small><i>" + data.dt + "</i></small></div></div></div></div>";

		let messages_area = document.getElementById('messages_area');

		messages_area.innerHTML = messages_area.innerHTML + html_data

		document.getElementById('chat_message').value = "";

		document.getElementById('messages_area').scrollTop = document.getElementById('messages_area').scrollHeight;
	};

	let chatForm = document.getElementById("chat_form");

	chatForm.addEventListener("submit", (e) => {

		event.preventDefault();

		var user_id = document.getElementById('login_user_id').value;

		var message = document.getElementById('chat_message').value;

		var data = {
			userId: user_id,
			msg: message
		};

		conn.send(JSON.stringify(data));
	});
</script>

</html>