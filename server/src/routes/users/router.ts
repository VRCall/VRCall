const { Router } = require("express");
const router = Router();

// Get methods
const registerUser = require("./POST_RegisterUser");
const loginUser = require("./POST_LoginUser");

// Add to router
router.post("/signup", registerUser);
router.post("/login", loginUser);

module.exports.routes = router;