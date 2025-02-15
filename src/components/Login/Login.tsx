import { useState } from 'react';
import useFetch from '../../hooks/useFetch';
import styles from './Login.module.css';

function Login() {
    const [email_register, set_email_register] = useState("");
    const [password_register, set_password_register] = useState("");
    const [email_login, set_email_login] = useState("");
    const [password_login, set_password_login] = useState("");

    // Check for the type of form and get the right inputs, send data to backend and wait for response,
    //   and finally reset the correct inputs. 
    async function handle_submit(event: React.FormEvent, type: 'register' | 'login') {
        event.preventDefault();

        let email, password;

        if (type === 'register') {
            email = email_register;
            password = password_register;
        } else {
            email = email_login;
            password = password_login;
        }

        try {
            const url = `http://localhost/film_review_react/backend/users.php?email=${email}&pd=${password}&type=${type}`;
            const data = await useFetch(url);

            alert(data.message);

            if (data.status === "ok" && data.token) {
                localStorage.setItem("token", data.token);
                localStorage.setItem("email", email);
                localStorage.setItem("id", data.userID);
                window.location.reload(); // Note: when reloading the console history get resetted
            }
            else {
                throw new Error("Response is not ok");
            }
        } catch (error) {
            console.error("Error:", error);
        }

        if (type === 'register') {
            set_email_register('');
            set_password_register('');
        } else {
            set_email_login('');
            set_password_login('');
        }
    }

    return (
        <main className={styles.main}>
            <section className={styles.center_column}>
                <h2 className={styles.title}>Register</h2>

                <form className={`${styles.center_column} ${styles.form}`} onSubmit={(e) => handle_submit(e, 'register')}>
                    <label htmlFor="email_register">
                        Email <br />
                        <input
                            className={styles.input}
                            type="email"
                            id="email_register"
                            value={email_register}
                            onChange={e => set_email_register(e.target.value)}
                            required
                        />
                    </label>

                    <br />

                    <label htmlFor="password_register">
                        Password <br />
                        <input
                            className={styles.input}
                            type="password"
                            id="password_register"
                            value={password_register}
                            onChange={e => set_password_register(e.target.value)}
                            required
                        />
                    </label>

                    <br />

                    <input className={styles.submit} type="submit" value="Register" />
                </form>
            </section>

            <section className={styles.center_column}>
                <h2 className={styles.title}>Login</h2>

                <form className={`${styles.center_column} ${styles.form}`} onSubmit={(e) => handle_submit(e, 'login')}>
                    <label htmlFor="email_login">
                        Email <br />
                        <input
                            className={styles.input}
                            type="email"
                            id="email_login"
                            value={email_login}
                            onChange={e => set_email_login(e.target.value)}
                            required
                        />
                    </label>

                    <br />

                    <label htmlFor="password_login">
                        Password <br />
                        <input
                            className={styles.input}
                            type="password"
                            id="password_login"
                            value={password_login}
                            onChange={e => set_password_login(e.target.value)}
                            required
                        />
                    </label>

                    <br />

                    <input className={styles.submit} type="submit" value="Login" />
                </form>
            </section>
        </main>
    );
}

export default Login;
