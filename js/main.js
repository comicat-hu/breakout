var canvas = document.querySelector(".canvas");
var ctx = canvas.getContext("2d");

var zoom = 0.9;
canvas.width = window.innerWidth * zoom;
canvas.height = window.innerHeight * zoom;

// paddle params
var paddleHeight = 10;
var paddleWidth = 75;
var paddleX = (canvas.width - paddleWidth) / 2;
var paddleColor = "#AE81FF";
var rightPressed = false;
var leftPressed = false;

// ball params
var ballRadius = 10;
var ballColor = "#AE81FF";
var x = canvas.width / 2;
var y = canvas.height - paddleHeight - ballRadius;
var speed = 10;
var dx = speed;
var dy = -speed;
var px, py;


// brick params
var brickRowCount = 5;
var brickColumnCount = 8;
var brickWidth = 75;
var brickHeight = 20;
var brickPadding = 3;
var brickOffsetTop = 30;
var brickOffsetLeft = (canvas.width - brickColumnCount * (brickWidth + brickPadding * 2)) / 2;
var brickColor = "#A6E227";
var bricks = [];

// game params
var runInterval;
var timeInterval;
var start = false;
var score = 0;
var time = 0;
var win = false;
var reqAF = true;
var fontColor = "#4862A3";

function drawBall() {
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, Math.PI * 2);
    ctx.fillStyle = ballColor;
    ctx.fill();
    ctx.closePath();
}

function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height - paddleHeight, paddleWidth, paddleHeight);
    ctx.fillStyle = paddleColor;
    ctx.fill();
    ctx.closePath();
}


function drawBricks() {
    for (var c = 0; c < brickColumnCount; c++) {
        for (var r = 0; r < brickRowCount; r++) {
            if (bricks[c][r].status === 1) {
                var brickX = (c * (brickWidth + brickPadding)) + brickOffsetLeft;
                var brickY = (r * (brickHeight + brickPadding)) + brickOffsetTop;
                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;
                ctx.beginPath();
                ctx.rect(brickX, brickY, brickWidth, brickHeight);
                ctx.fillStyle = brickColor;
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}

function drawScore() {
    ctx.font = "16px Consolas";
    ctx.fillStyle = fontColor;
    ctx.fillText("Score: " + score, 8, 20);
}

function drawTime() {
    ctx.font = "16px Consolas";
    ctx.fillStyle = fontColor;
    ctx.fillText("Time: " + time, 120, 20);
}

function collisionDirection(bx, by) {
    if (px <= bx || px >= bx + birckWidth) {
        dx = -dx;
    }
    if (py <= by || py >= by + birckHeight) {
        dy = -dy;
    }
}

function collisionDetection() {
    for (var c = 0; c < brickColumnCount; c++) {
        for (var r = 0; r < brickRowCount; r++) {
            var b = bricks[c][r];
            if (b.status === 1) {
                if (x >= b.x && x <= b.x + brickWidth && y >= b.y && y <= b.y + brickHeight) {
                    dy = -dy;
                    //collisionDirection(b.x, b.y);
                    b.status = 0;
                    score++;

                }
            }
        }
    }
}


function keyDownHandler(e) {
    if (e.keyCode == 39) {
        rightPressed = true;
    }
    else if (e.keyCode == 37) {
        leftPressed = true;
    }
}

function keyUpHandler(e) {
    if (e.keyCode == 39) {
        rightPressed = false;
    }
    else if (e.keyCode == 37) {
        leftPressed = false;
    }
}

function mouseMoveHandler(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if (relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth / 2;
    }
}

// Mouse Right Click
function mouseUpHandler(e) {
    if (e.which === 3) {
        document.querySelector(".canvas").oncontextmenu = function (e) { return false; }
        start = true;
        timeInterval = setInterval(() => { time++; }, 1000);
    }
}


function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBall();
    drawPaddle();
    drawBricks();
    drawScore();
    drawTime();

    if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
        dx = -dx;
    }
    if (y + dy < ballRadius) {
        dy = -dy;
    }
    else if (y + dy > canvas.height - ballRadius) {
        if (x > paddleX && x < paddleX + paddleWidth) {
            dy = -dy;
        }
        else if (y + dy > canvas.height + ballRadius) {
            clearInterval(runInterval);
            clearInterval(timeInterval);
            start = false;
            win = false;
            reqAF = false;
            alert("GAME OVER");
            putRecord().then(() => {
                location.href = "record.php";
            });
        }
    }



    if (rightPressed && paddleX < canvas.width - paddleWidth) {
        paddleX += 5;
    }
    else if (leftPressed && paddleX > 0) {
        paddleX -= 5;
    }


    if (start) {
        px = x;
        py = y;
        x += dx;
        y += dy;
        collisionDetection();
    } else {
        x = paddleX + paddleWidth / 2;
    }


    if (score === brickRowCount * brickColumnCount) {
        clearInterval(runInterval);
        clearInterval(timeInterval);
        start = false;
        win = true;
        reqAF = false;
        alert("WIN!");
        putRecord().then(() => {
            location.href = "record.php";
        });
    }

    // if (reqAF) {
    //     requestAnimationFrame(draw);
    // }

}

function putRecord() {
    return new Promise((resolve, reject) => {
        console.log("putRecord");
        console.log(username);

        let putUrl = "php/putmongo.php";
        let getUrl = "php/getmongo.php";

        $.post(getUrl, { "_id": username })
            .done((response) => {
                console.log(response);
                var userData = JSON.parse(response);
                $.post(putUrl, {
                    "_id": username,
                    "lastloginTS": lastloginTS,
                    "win": parseInt(userData["win"], 10) + win,
                    "lose": parseInt(userData["lose"], 10) + !win,
                    "totalScore": parseInt(userData["totalScore"], 10) + score,
                    "totalPlayTime": parseInt(userData["totalPlayTime"], 10) + time,
                }).done((res) => {
                    console.log(res);
                    return resolve();
                });
            });
    });
}


for (c = 0; c < brickColumnCount; c++) {
    bricks[c] = [];
    for (r = 0; r < brickRowCount; r++) {
        bricks[c][r] = {
            x: 0,
            y: 0,
            status: 1
        };
    }
}


document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);
document.querySelector(".canvas").addEventListener("mousemove", mouseMoveHandler, false);

document.querySelector(".canvas").addEventListener("mouseup", mouseUpHandler);

//draw();
runInterval = setInterval(draw, 50);