"use strict";
import "../main.js";

import Auction from "../Auction.js";
import ReactDOM from "react-dom";
import React from "react";

document.addEventListener("DOMContentLoaded", function() {
	ReactDOM.render(<Auction/>, document.getElementById("auction"));
});
