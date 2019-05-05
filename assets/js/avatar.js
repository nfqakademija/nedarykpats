const email = document.querySelector('#registration_form_email');

if (email) {
    let password = document.querySelector('#registration_form_plainPassword'),
        mySVG = document.querySelector('.avatarContainer'),
        armL = document.querySelector('.armL'),
        armR = document.querySelector('.armR'),
        eyeL = document.querySelector('.eyeL'),
        eyeR = document.querySelector('.eyeR'),
        nose = document.querySelector('.nose'),
        mouth = document.querySelector('.mouth'),
        face = document.querySelector('.face'),
        hair = document.querySelector('.hair');

    let caretPos, curEmailIndex, screenCenter, svgCoords, eyeMaxHorizD = 20, eyeMaxVertD = 10, noseMaxHorizD = 23,
        noseMaxVertD = 10, dFromC, eyeDistH, eyeLDistV, eyeRDistV, eyeDistR, mouthStatus = "small";

    email.type = 'text';

    const getCoord = (e) => {
        let carPos = email.selectionEnd,
            div = document.createElement('div'),
            span = document.createElement('span'),
            copyStyle = getComputedStyle(email),
            emailCoords = {}, caretCoords = {}, centerCoords = {}
        ;

        [].forEach.call(copyStyle, function (prop) {
            div.style[prop] = copyStyle[prop];
        });
        div.style.position = 'absolute';
        document.body.appendChild(div);
        div.textContent = email.value.substr(0, carPos);
        span.textContent = email.value.substr(carPos) || '.';
        div.appendChild(span);

        emailCoords = getPosition(email);
        caretCoords = getPosition(span);

        centerCoords = getPosition(mySVG);
        svgCoords = getPosition(mySVG);
        screenCenter = centerCoords.x + (mySVG.offsetWidth / 2);
        caretPos = caretCoords.x + emailCoords.x;

        dFromC = screenCenter - caretPos;
        let pFromC = Math.round((caretPos / screenCenter) * 100) / 100;
        if (pFromC < 1) {

        } else if (pFromC > 1) {
            pFromC -= 2;
            pFromC = Math.abs(pFromC);
        }

        eyeDistH = -dFromC * .05;
        if (eyeDistH > eyeMaxHorizD) {
            eyeDistH = eyeMaxHorizD;
        } else if (eyeDistH < -eyeMaxHorizD) {
            eyeDistH = -eyeMaxHorizD;
        }

        let eyeLCoords = {x: svgCoords.x + 84, y: svgCoords.y + 76};
        let eyeRCoords = {x: svgCoords.x + 113, y: svgCoords.y + 76};
        let noseCoords = {x: svgCoords.x + 97, y: svgCoords.y + 81};
        let mouthCoords = {x: svgCoords.x + 100, y: svgCoords.y + 100};
        let eyeLAngle = getAngle(eyeLCoords.x, eyeLCoords.y, emailCoords.x + caretCoords.x, emailCoords.y + 25);
        let eyeLX = Math.cos(eyeLAngle) * eyeMaxHorizD;
        let eyeLY = Math.sin(eyeLAngle) * eyeMaxVertD;
        let eyeRAngle = getAngle(eyeRCoords.x, eyeRCoords.y, emailCoords.x + caretCoords.x, emailCoords.y + 25);
        let eyeRX = Math.cos(eyeRAngle) * eyeMaxHorizD;
        let eyeRY = Math.sin(eyeRAngle) * eyeMaxVertD;
        let noseAngle = getAngle(noseCoords.x, noseCoords.y, emailCoords.x + caretCoords.x, emailCoords.y + 25);
        let noseX = Math.cos(noseAngle) * noseMaxHorizD;
        let noseY = Math.sin(noseAngle) * noseMaxVertD;
        let mouthAngle = getAngle(mouthCoords.x, mouthCoords.y, emailCoords.x + caretCoords.x, emailCoords.y + 25);
        let mouthX = Math.cos(mouthAngle) * noseMaxHorizD;
        let mouthY = Math.sin(mouthAngle) * noseMaxVertD;
        let mouthR = Math.cos(mouthAngle) * 6;
        let hairX = Math.cos(mouthAngle) * 6;
        let hairY = Math.sin(mouthAngle) * (-6);

        TweenMax.to(eyeL, 1, {x: -eyeLX, y: -eyeLY, ease: Expo.easeOut});
        TweenMax.to(eyeR, 1, {x: -eyeRX, y: -eyeRY, ease: Expo.easeOut});
        TweenMax.to(nose, 1, {
            x: -noseX,
            y: -noseY,
            rotation: mouthR,
            transformOrigin: "center center",
            ease: Expo.easeOut
        });
        TweenMax.to(mouth, 1, {
            x: -mouthX,
            y: -mouthY,
            rotation: mouthR,
            transformOrigin: "center center",
            ease: Expo.easeOut
        });
        TweenMax.to(hair, 1, {
            x: hairX,
            y: hairY,
            rotation: mouthR,
            transformOrigin: "center center",
            ease: Expo.easeOut
        });

        document.body.removeChild(div);
    };

    const onEmailInput = (e) => {
        getCoord(e);
        var value = e.target.value;
        curEmailIndex = value.length;
    };

    const onEmailFocus = (e) => {
        e.target.parentElement.classList.add("focusWithText");
        getCoord();
    };

    const onEmailBlur = (e) => {
        if (e.target.value == "") {
            e.target.parentElement.classList.remove("focusWithText");
        }
        resetFace();
    };

    const onPasswordFocus = (e) => coverEyes();

    const onPasswordBlur = (e) => uncoverEyes();

    const coverEyes = () => {
        TweenMax.to(armL, .45, {x: 0, y: 2, rotation: 0});
        TweenMax.to(armR, .45, {x: 0, y: 2, rotation: 0, ease: Quad.easeOut});
        // TweenMax.to(armL, .45, {x: 0, y: 2, rotation: 0, ease: Quad.easeOut});
        // TweenMax.to(armR, .45, {x: 0, y: 2, rotation: 0, ease: Quad.easeOut});
        // TweenMax.to(armR, .45, {x: 0, y: 2, rotation: 0, ease: Quad.easeOut, delay: .1});
    };

    const uncoverEyes = () => {
        TweenMax.to(armL, 1.35, {y: 220, ease: Quad.easeOut});
        TweenMax.to(armL, 1.35, {rotation: 105, ease: Quad.easeOut, delay: .1});
        TweenMax.to(armR, 1.35, {y: 220, ease: Quad.easeOut});
        TweenMax.to(armR, 1.35, {rotation: -105, ease: Quad.easeOut, delay: .1});
    };

    const resetFace = () => {
        TweenMax.to([eyeL, eyeR], 1, {x: 0, y: 0, ease: Expo.easeOut});
        TweenMax.to([nose], 1, {x: 0, y: 0, scaleX: 1, scaleY: 1, ease: Expo.easeOut});
        TweenMax.to(mouth, 1, {x: 0, y: 0, rotation: 0, ease: Expo.easeOut});
        TweenMax.to([face], 1, {x: 0, y: 0, skewX: 0, ease: Expo.easeOut});
        TweenMax.to(hair, 1, {x: 0, y: 0, rotation: 0, scaleX: 1, scaleY: 1, ease: Expo.easeOut});
    };

    const getAngle = (x1, y1, x2, y2) => {
        return Math.atan2(y1 - y2, x1 - x2);
    };

    const getPosition = (el) => {
        let xPos = 0;
        let yPos = 0;

        while (el) {
            if (el.tagName == "BODY") {
                // deal with browser quirks with body/window/document and page scroll
                var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
                var yScroll = el.scrollTop || document.documentElement.scrollTop;

                xPos += (el.offsetLeft - xScroll + el.clientLeft);
                yPos += (el.offsetTop - yScroll + el.clientTop);

            } else {
                xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
                yPos += (el.offsetTop - el.scrollTop + el.clientTop);
            }

            el = el.offsetParent;
        }
        return {
            x: xPos,
            y: yPos
        };
    };

    email.addEventListener('focus', onEmailFocus);
    email.addEventListener('blur', onEmailBlur);
    email.addEventListener('input', onEmailInput);
    password.addEventListener('focus', onPasswordFocus);
    password.addEventListener('blur', onPasswordBlur);
    TweenMax.set(armL, {x: -93, y: 220, rotation: 105, transformOrigin: "top left"});
    TweenMax.set(armR, {x: -93, y: 220, rotation: -105, transformOrigin: "top right"});
}
