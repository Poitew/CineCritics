import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import useFetch from "../../hooks/useFetch";
import useRemoveTags from "../../hooks/useRemoveTags";
import styles from "./Reviews.module.css";

function Reviews(){
    const [movie_data, set_movie_data] = useState<any>({}); // Movie data such as title, description, image...
    const [reviews, set_reviews] = useState<any[]>([]); // Array of reviews from backend
    const [review, set_review] = useState<any>(""); // Review in input form
    const [updated_review, set_updated_review] = useState<any>("") // Review in the change review input 
    const { id } = useParams(); // Movie ID

    // Fetch info about the correct movie, and fetch all the reviews
    useEffect(() => {
        const fetch_data = async () => {
            const movie_results = await useFetch(`https://api.tvmaze.com/shows/${id}`)
            set_movie_data(movie_results);

            const reviews_results = await useFetch(`http://localhost/film_review_react/backend/get_reviews.php?id=${id}`);
            set_reviews(reviews_results.content || []);
        }

        fetch_data();
    }, [id])

    // Used to send a new review or modify an existing one -> fetch param: movie id, user id, review, type ->
    //   automatically reload the window to update the review
    async function handle_submit_review(event : React.FormEvent, type: "new" | "change", index: number = 0){
        event.preventDefault();

        const url = `http://localhost/film_review_react/backend/submit_review.php?`;
        const review_text = type === "change" ? updated_review : review;
        const params = `
            movieID=${id}
            &userID=${localStorage.getItem("id")}
            &review=${encodeURIComponent(review_text)}
            &type=${type}
            ${type === "change" ? `&id=${reviews[index].ID}` : ""}
        `.trim().replace(/\s+/g, ""); // Removes unnecesary whitespaces inserted when formatting the string

        const results = await useFetch(url + params);
        
        if(results){
            alert(results.message);
            window.location.reload();
        }
    }

    // Delete a review by sending the review index to the backend
    async function handle_delete_review(index: number){
        const results = await useFetch(`http://localhost/film_review_react/backend/delete_review.php?id=${reviews[index].ID}`);

        alert(await results.message);
        window.location.reload();
    }

    return(
        <>
        {movie_data ? (
            <main className={styles.main} >
                <section className={styles.info_wrapper}>
                    <img src={movie_data.image?.medium || "/tv_placeholder.jpg"} alt={movie_data.name} className={styles.img} />

                    <article className={styles.info}>
                        <h1 className={styles.title}>{movie_data.name}</h1>
                        <p className={styles.summary} >{useRemoveTags(movie_data.summary || "")}</p>
                        {movie_data.genres && (
                            <ul className={styles.list}>
                                {movie_data.genres.map((genre: string) => (
                                    <li key={genre}>{genre}</li>
                                ))}
                            </ul>
                        )}
                    </article>
                </section>

                <section>
                    <h2>Reviews</h2>
                    <form method="get" className={styles.form} onSubmit={(e) => handle_submit_review(e, "new")} >
                        <label htmlFor="review">
                            Type in what you think about this TV show <br/>
                            <input type="text" name="review" id="review" className={styles.input} onChange={(e) => set_review(e.target.value)} />
                        </label>
                        <input type="submit" value="Submit review" className={styles.submit} />
                    </form>
                    
                    <ReviewsSection
                    reviews={reviews}
                    handle_submit_review={handle_submit_review}
                    set_updated_review={set_updated_review}
                    handle_delete_review={handle_delete_review}
                    />
                    
                </section>
            </main>
        ) : (
            <p>No data</p>
        )}
        </>
    );
}

interface propsRS {
    reviews: any[],
    handle_submit_review: Function,
    set_updated_review: Function,
    handle_delete_review: Function
}

function ReviewsSection({ reviews, handle_submit_review, set_updated_review, handle_delete_review } : propsRS){
    const [open_forms, set_open_forms] = useState<{ [key: number]: boolean }>({});

    
    const toggleForm = (reviewID: number) => {
        set_open_forms(prevState => ({
            ...prevState,
            [reviewID]: !prevState[reviewID]
        }));
    };

    return (
        <article className={styles.reviews}>
        {reviews.length > 0 ? (
            reviews.map((review: any, index: number) => (
                <div key={review.ID}> 
                    <p>{index + 1} - {review.review}</p>

                    {/* Show the form only for the logged in user comments */}
                    {review.userID == localStorage.getItem("id") && (
                        <>
                        <p className={styles.action} onClick={() => toggleForm(review.ID)}>
                            Click here to show/hide review actions
                        </p>
                        {open_forms[review.ID] && ( 
                            <form className={styles.form_change} onSubmit={(e) => handle_submit_review(e, "change", index)}>
                                <textarea className={styles.input_change} id="change" name="change" onChange={(e) => set_updated_review(e.target.value)} />
                                <div className={styles.buttons}>
                                    <input className={styles.button} type="submit" value="Change review" />
                                    <input type="button" className={styles.button} onClick={() => handle_delete_review(index)} value="Delete Review" />
                                </div>
                            </form>
                        )}
                        </>
                    )}
                </div>
            ))
        ) : (
            <p>No reviews for this show yet. Be the first!</p>
        )}
        </article>
    );
}


export default Reviews;