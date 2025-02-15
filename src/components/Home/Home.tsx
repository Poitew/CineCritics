import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import useFetch from '../../hooks/useFetch';
import useRemoveTags from '../../hooks/useRemoveTags';
import styles from './Home.module.css';

function Home() {
    const [data, setData] = useState<any>([]);
    const [random, setRandom] = useState<number>(0);
    const BEST_SERIES = 15; // Number of the top show to randomize

    // Fetch tv shows resources, sort the shows by highest rating, generate random number
    //   used to show a random tv show at the beginning 
    useEffect(() => {
        const fetch_data = async () => {
            const result = await useFetch('https://api.tvmaze.com/shows');
            const sorted_data = result.sort((a: any, b: any) => b.rating.average - a.rating.average);
            
            setData(sorted_data);
        };

        fetch_data();
        setRandom(Math.floor(Math.random() * BEST_SERIES));
    }, []);

    return (
        <>
            {data.length > 0 &&(
                <>
                    <main className={styles.main} >
                        <img src={data[random].image.medium} alt={data[random].name} className={styles.img} />

                        <section className={styles.info} >
                            <h1 className={styles.title} >{data[random].name}</h1>
                            <p className={styles.summary} >{useRemoveTags(data[random].summary)}</p>

                            <ul className={styles.list} >
                                {data[random].genres.map((genre: string) => (
                                    <li key={genre}>{genre}</li>
                                ))}
                            </ul>

                            <Link to={`/reviews/${data[random].id}`} className={`${styles.reviews} center`} >Reviews</Link>
                        </section>
                    </main>

                    <section className={styles.section} >
                        <h2 className={styles.sub_title} >Most populars of all times &gt; </h2>
                        
                        <article className={styles.tv_shows} >
                            {data.map((serie: any, index: number) => (
                                // Show N + 10 shows except for the random one 
                                (index < (BEST_SERIES + 10) && index != random) && (
                                    <div key={serie.id} className={styles.card} >
                                        <Link to={`/reviews/${serie.id}`}>
                                            <img src={serie.image.medium} alt={`Show is ${serie.name}`} className={styles.card_img} />
                                            <h3 className={styles.card_title} >{serie.name}</h3>
                                        </Link>
                                    </div>
                                )
                            ))}
                        </article>
                    </section>
                </>
            )}
        </>
    );
}

export default Home;