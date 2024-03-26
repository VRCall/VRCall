const { Router } = require("express");
const router = Router();

// Get methods
const registerUser = require("./POST_RegisterUser");

// Add to router
router.post("/signup", registerUser);

module.exports.routes = router;