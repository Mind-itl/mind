import "../main.js";

import StatusTables from "../StatusTables.js";
import ReactDOM from "react-dom";
import React from "react";

document.addEventListener("DOMContentLoaded", function() {
	ReactDOM.render(<StatusTables/>, document.getElementById("statuses"));
});
