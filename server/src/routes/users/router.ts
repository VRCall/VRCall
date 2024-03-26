const { Router } = require("express");
const router = Router();
import { Request, Response } from "express";
import authentication from "../../utils/auth";

// Get methods
const registerUser = require("./POST_RegisterUser");
const loginUser = require("./POST_LoginUser");

// Add to router
router.post("/signup", registerUser);
router.post("/login", loginUser);
router.post("/auth", authentication, (req: Request, res: Response) => {
    res.json(true);
})

module.exports.routes = router;