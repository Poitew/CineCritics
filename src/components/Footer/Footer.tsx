import { Link } from 'react-router-dom';
import styles from './Footer.module.css';

function Footer() {
    return (
        <footer className={styles.footer} >
            <div className={styles.logo}>
                <Link to="/">CineCritics</Link>
            </div>

            <ul className={styles.ul}>
                <li><Link to="/">Home</Link></li>
                <li><Link to="/movie_list">TV Series List</Link></li>
                <li><Link to="/login">Login</Link></li>
            </ul>

            <p className={styles.company_footer} >CineCritics <br/>Made by sickpoitew</p>
        </footer>
    );
}

export default Footer;