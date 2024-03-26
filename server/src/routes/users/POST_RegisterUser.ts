import { Request, Response } from "express";
import prisma from "../../utils/prisma";
const bcrypt = require("bcrypt");
import z from "zod";

const RegisterSchema = z.object({
    pseudo: z.string().regex(/^[A-Za-z0-9_.]+$/),
    email: z.string().email(),
    password: z.string().min(6),
    confirmPassword: z.string().min(6)
}).refine((data) => data.password === data.confirmPassword, {
    "message": "The passwords are not identical"
})

module.exports = async (req: Request, res: Response) => {

    try {

        const { pseudo, email, password, confirmPassword } = req.body;

        console.log(req.body);
        
        
        // if(profilePicture !== null && !profilePicture?.type.startsWith("image/")) {
        //     return "Error"
        // }

        // let newFileName;

        // if(profilePicture !== null) {
        //     let fileExtension = profilePicture.name.split(".").pop();
        //     newFileName = "/" + crypto.randomUUID() + "." + fileExtension;
        // }
        // else {
        //     newFileName = "/default.png";
        // } 

        const validatedFields = RegisterSchema.safeParse({
            pseudo: pseudo,
            email: email,
            password: password,
            confirmPassword: confirmPassword,
        });

        if(!validatedFields.success) {
            return res.status(400).json({ message: validatedFields.error });
        }

        const userExists = await prisma.user.findFirst({
            where: {
                OR: [
                    { email: validatedFields.data.email },
                    { pseudo: validatedFields.data.pseudo }
                ]
            }
        });

        if(userExists !== null) {
            return res.status(400).json({ message: "Already in use" });
        }

        const hashedPassword = await bcrypt.hash(validatedFields.data.password, parseInt(process.env.SALTS!));

        await prisma.user.create({
            data: {
                pseudo: validatedFields.data.pseudo,
                email: validatedFields.data.email,
                password: hashedPassword,
                img: "/default.png"
            }
        });

        return res.status(201);

    }
    catch(error: any) {
        console.log("Error : " + error);
        return res.status(500).json({ message: "An error occured : " + error });
    }

}