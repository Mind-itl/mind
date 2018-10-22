'use strict';

import "../main.js";
import $ from "jquery";

import React from "react";
import ReactDOM from "react-dom";

import MusicList from "../MusicList.js";

document.addEventListener("DOMContentLoaded", function() {
	ReactDOM.render(<MusicList/>, document.getElementById("music_list"));
});
