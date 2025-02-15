import { useEffect, useState, useRef } from "react";
import { Link, useNavigate } from "react-router-dom";
import styles from "./Header.module.css";

function Header() {
    const [user_email, set_user_email] = useState<string | null>(localStorage.getItem("email"));
    const input_ref = useRef<HTMLInputElement>(null);
    const navigate = useNavigate();

    // Check if the token is valid, used to see if the session is expired
    useEffect(() => {
        const checkToken = async () => {
            const token = localStorage.getItem("token");

            if (!token) {
                set_user_email(null);
                return;
            }

            try {
                const response = await fetch("http://localhost/film_review_react/backend/validate_token.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                if (!response.ok) {
                    throw new Error("Token not valid");
                }

                const data = await response.json();
                if (data.status !== "ok") {
                    throw new Error("Token expired");
                }
            } catch (error) {
                localStorage.removeItem("token");
                localStorage.removeItem("id");
                localStorage.removeItem("email");
                set_user_email(null);
            }
        };

        checkToken();
    }, []);

    function handle_submit(event: React.FormEvent) {
        if (input_ref.current) {
            event.preventDefault();

            const search = input_ref.current.value;
            input_ref.current.value = "";

            navigate(`/search/${search}`);
        }
    }

    return (
        <header className={styles.header}>
            <Link to="/" className={styles.logo}>CineCritics</Link>

            <form method="get" className={styles.form} onSubmit={handle_submit}>
                <input ref={input_ref} type="text" placeholder="Search a Tv series" className={styles.input} name="search" />
                <input type="submit" value="" className={styles.submit} />
            </form>

            <Link to="/">Home</Link>

            <Link to="/login">{user_email ? user_email : "Login"}</Link>
        </header>
    );
}

export default Header;