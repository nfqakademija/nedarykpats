import React, { Component } from 'react';
import { throws } from 'assert';

class LoginAvatar extends Component{

    render(){

        return(
            <div className="Form-avatar u-align-center u-margin-top-bottom">

                <div className="avatarContainer">
                    <svg className="avatarContainer-svg"
                         viewBox="20 0 420 420">

                        <g className="face">
                            <path id="XMLID_15_" className="st0" d="M142.1,185.4c0,0-1.8,55.1,0,73.6c0.6,6.4,7.1,18.7,12,23c6.7,5.9,24.6,12.2,33.6,12.4 c24.1,0.5,73,1,97.5,0c7.8-0.3,22.4-8,28.1-13.3c5.1-4.8,12.2-17.3,12.7-24.3c1.5-20.4-0.7-71.4-0.7-71.4s-68.2-16.1-91.4-16.1 C210.5,169.3,142.1,185.4,142.1,185.4z"/>
                        </g>

                        <g className="body">
                            <rect id="XMLID_14_" x="184.7" y="294.2" className="st1" width="98.1" height="30.7"/>
                            <path id="XMLID_13_" className="st0" d="M328.2,324.9c7.1,0.2,12.8,4.3,13.6,8.2c3.7,16.7,17.7,61.4,17.9,85.1 c0.1,8.5-13.1,16.4-13.1,16.4l-215.4-2.4l-25.5-15.2c0,0,15.1-61,19.4-82.8c0.8-3.9,4-9.5,10-9.5 C151.4,324.9,328,324.9,328.2,324.9z"/>
                            <rect id="XMLID_12_" x="151.5" y="324.9" className="st2" width="28.1" height="60.7"/>
                            <rect id="XMLID_11_" x="287.2" y="324.9" className="st2" width="28.1" height="60.7"/>
                            <polygon id="XMLID_46_" className="st2" points="327.6,433.9 140.5,431.3 151.5,385.6 315.3,385.6 	"/>
                            <path id="XMLID_10_" className="st0" d="M123.6,341.8c0,0-17.3,0.4-27.1,4.5c-10.3,4.3-38,33.1-38,33.1s14.6,15,19.5,19.5 c6.8,6.2,33.3,21.6,33.3,21.6L123.6,341.8z"/>
                            <path id="XMLID_9_" className="st0" d="M343.8,339.1c0,0,15.1-0.8,25.4,4.5c14.1,7.2,23.9,15.2,29.9,27.3c7.1,14.4,4.6,14.7,4.6,14.7 l-42.3,41.1L343.8,339.1z"/>
                        </g>

                        <g className="hair">
                            <path id="XMLID_7_" className="st3" d="M114.8,190c-4-17.3,26.4-26,26.4-26s2.6-25.2,7.8-35.3c3.3-6.5,13.9-19.9,27.3-23.3 c15-3.9,32.9-2.1,32.9-2.1v26.8c0,0,0-32.6,0-43.5c0-4.8,4.2-9.1,9.9-9c7.7,0.1,22.8,0.1,31.2,0c6.8-0.1,9.3,5.7,9.4,8.9 c0.2,5.1,0.2,16.2,0.2,16.2v27.4V103c0,0,20.3-2.7,31.4,2.3c12.7,5.7,18.4,9.9,22.3,14.5c9.9,11.5,12.8,43.9,12.8,43.9 s26.7,10,25.4,24.3c-0.5,5.3-87.1-19-118-18.7C203.6,169.6,115.5,193,114.8,190z"/>
                            <line id="XMLID_6_" className="st1" x1="116.4" y1="190.3" x2="140.8" y2="215.3"/>
                            <line id="XMLID_5_" className="st1" x1="347.6" y1="188.7" x2="326.1" y2="215.9"/>
                        </g>

                        <g className="eyeL">
                            <path id="XMLID_4_" className="st4" d="M203.9,214.6c3.4,0,6.1-2.7,6.1-6.1v-12.3c0-3.4-2.7-6.1-6.1-6.1c-3.4,0-6.1,2.7-6.1,6.1v12.3 C197.8,211.8,200.6,214.6,203.9,214.6z"/>
                        </g>

                        <g className="eyeR">
                            <path id="XMLID_3_" className="st4" d="M265.3,214.6c3.4,0,6.1-2.7,6.1-6.1v-12.3c0-3.4-2.7-6.1-6.1-6.1c-3.4,0-6.1,2.7-6.1,6.1v12.3 C259.1,211.8,261.9,214.6,265.3,214.6z"/>
                        </g>

                        <g className="mouth">
                            <path id="XMLID_37_" className="st4" d="M203.9,239.1c0,0.8,0.3,18.4,30.7,18.4s30.7-17.7,30.7-18.4c0-3.4-2.7-6.2-6.1-6.3 c-1.6,0-3.2,0.6-4.3,1.7c-1.2,1.1-1.8,2.7-1.8,4.3c-0.3,2.2-4.5,6.5-18.4,6.5s-18.1-4.2-18.4-6.1c0-3.4-2.7-6.1-6.1-6.1 C206.7,233,203.9,235.7,203.9,239.1z"/>
                        </g>

                        <g className="nose">
                            <path id="XMLID_36_" className="st4" d="M173.3,233c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C170.5,226.8,173.3,229.6,173.3,233z"/>
                            <path id="XMLID_35_" className="st4" d="M173.3,251.4c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C170.5,245.2,173.3,248,173.3,251.4z"/>
                            <path id="XMLID_2_" className="st4" d="M191.7,251.4c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C188.9,245.2,191.7,248,191.7,251.4z"/>
                            <path id="XMLID_33_" className="st4" d="M191.7,269.8c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C188.9,263.6,191.7,266.4,191.7,269.8z"/>
                            <path id="XMLID_1_" className="st4" d="M210.1,269.8c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C207.3,263.6,210.1,266.4,210.1,269.8z"/>
                            <path id="XMLID_31_" className="st4" d="M308.2,233c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C305.5,226.8,308.2,229.6,308.2,233z"/>
                            <path id="XMLID_30_" className="st4" d="M308.2,251.4c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C305.5,245.2,308.2,248,308.2,251.4z"/>
                            <path id="XMLID_29_" className="st4" d="M289.8,251.4c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C287.1,245.2,289.8,248,289.8,251.4z"/>
                            <path id="XMLID_28_" className="st4" d="M289.8,269.8c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C287.1,263.6,289.8,266.4,289.8,269.8z"/>
                            <path id="XMLID_27_" className="st4" d="M271.4,269.8c0,3.4-2.7,6.1-6.1,6.1c-3.4,0-6.1-2.7-6.1-6.1c0-3.4,2.7-6.1,6.1-6.1 C268.7,263.6,271.4,266.4,271.4,269.8z"/>
                        </g>
                        <g className="arms">
                            <g className="armL">
                                <path id="XMLID_85_" className="st5" d="M98.8,268.6l-7.9-50.3c6.7-2.6,12.3-5.5,14-8.7c0,0,15.5-27.3,34.2-30.1 c19-3.2,24.9-14.2,24.9-14.2c1.9-2,4.7-2.5,6.2-2.5c4.3,0.1,8.4,4,7.3,7.7c-2.1,7.8-8.7,14.9-16.5,21.1l53.3-12.1 c4.7-1.1,9.2,1.6,10.2,6.3c1.4,4.9-1.5,9.7-6.4,11.1l-46.5,11.6c-0.6,0.1-0.8,0.4-0.7,1c0.1,0.6,0.4,0.8,1,0.7l51.5-12.4 c4.1-1,8.7,0.8,10.3,4.9c0.3,0.2,0.1,0.6,0.4,0.8l0,0c1.1,4.7-1.8,9.5-6.5,10.6l-49.1,11.7c-0.6,0.1-0.8,0.4-0.7,1 c0.1,0.6,0.4,0.8,1,0.7l37.8-8.9c4.9-1.4,9.8,2.1,10.4,7.4c0.4,4.2-2.7,7.9-6.8,8.9l-41.4,9.8c-0.6,0.1-0.8,0.4-0.7,1 c0.1,0.6,0.4,0.8,1,0.7l26.3-5.9c4.1-1,8.6,1.7,9.6,5.8c1.3,4.4-1.6,9.2-6.3,10.2l-33.7,7.4c-14.6,3.3-29.3,4.7-44,4.5l-12.6-0.2 C118.3,268.2,109.9,268.2,98.8,268.6z"/>
                                <path id="XMLID_84_" className="st0" d="M-22.8,229.6c8.4,24.1,20.9,47.3,36.4,68.1l89.2-16.8l-11.7-72.6L-22.8,229.6z"/>
                            </g>
                            <g className="armR">
                                <path id="XMLID_87_" className="st5" d="M378.6,275.2l12.3-50.7c-6.7-2.9-12.2-6-13.8-9.3c0,0-13.7-28.2-32.8-31.8 c-19.3-3.9-24.5-15.3-24.5-15.3c-1.8-2.1-4.7-2.7-6.2-2.7c-4.5,0-9,3.8-8.2,7.5c1.5,8,7.7,15.5,15.3,22l-54-14.3 c-4.8-1.3-9.6,1.3-11.1,6c-1.9,4.9,0.8,9.9,5.7,11.5l47.1,13.5c0.6,0.1,0.8,0.5,0.6,1c-0.1,0.6-0.5,0.8-1.1,0.7l-52.2-14.5 c-4.2-1.2-9.1,0.5-11,4.5c-0.4,0.2-0.1,0.6-0.5,0.8l0,0c-1.5,4.7,1.1,9.7,5.9,11l49.7,13.7c0.6,0.1,0.8,0.5,0.6,1 c-0.1,0.6-0.5,0.8-1.1,0.7l-38.3-10.5c-5-1.6-10.3,1.7-11.4,7.1c-0.8,4.3,2.1,8.1,6.3,9.3l41.9,11.5c0.6,0.1,0.8,0.5,0.6,1 c-0.1,0.6-0.5,0.8-1.1,0.7l-26.6-6.9c-4.2-1.2-9,1.4-10.4,5.6c-1.7,4.4,0.9,9.3,5.7,10.6l34.2,8.8c14.8,3.9,29.9,5.8,45,6.2 l13.1,0.3C358.6,274.1,367.2,274.4,378.6,275.2z"/>
                                <path id="XMLID_86_" className="st0" d="M507.8,237.2c-10.6,24.1-25.4,47.1-43.2,67.7l-89.1-17.3l18-73.1L507.8,237.2z"/>
                            </g>
                        </g>


                    </svg>
                </div>
            </div>
        )
    }
}

export default LoginAvatar;
