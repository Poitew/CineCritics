import { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";
import useFetch from "../../hooks/useFetch";
import styles from "../Home/Home.module.css"; // Maybe not the best idea - less flexability but DRY compliant

function Search(){
    const [data, setData] = useState<any>([]);
    const { q } = useParams();

    // Fetch the shows matching with the query
    useEffect(() => {
        const fetch_data = async () => {
            if (!q) return;

            const result = await useFetch(`https://api.tvmaze.com/search/shows?q=${encodeURIComponent(q)}`);
            setData(result || []);
        }

        fetch_data();
    }, [q]);

    return(
        <>
            {data.length > 0 ? (
                <main className={styles.tv_shows} >
                    {data.map((serie: any, index: number) => (
                        <div key={index} className={styles.card} >
                            <Link to={`/reviews/${serie.show.id}`}>
                                <img src={serie.show.image?.medium || "/tv_placeholder.jpg"} alt={serie.show.name} className={styles.card_img} />
                                <h3 className={styles.card_title} >{serie.show.name}</h3>
                            </Link>
                        </div>
                    ))}
                </main>
            ) : (
                <p>No data</p>
            )}
        </>
    );
}

export default Search;