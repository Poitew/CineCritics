async function useFetch(url: string){
    try {
        const response: Response = await fetch(url);

        if (!response.ok) {
            throw new Error(response.statusText);
        }

        return await response.json();
    } catch (error) {
        console.error(error);
    }
}

export default useFetch;