import axios, { AxiosInstance, AxiosRequestConfig } from "axios";

export default class Request {
    private static API: AxiosInstance = axios.create({
        baseURL: "/api",
        withCredentials: true,
    });

    static async request<T, R>(
        method: "get" | "post" | "patch" | "delete",
        url: string,
        data?: R,
        config?: AxiosRequestConfig
    ): Promise<T> {
        try {
            const authToken = localStorage.getItem("auth_token");
            const body = {
                method,
                url,
                data,
                ...config,
            };
            if (authToken) {
                body.headers = {
                    ...body.headers,
                    Authorization: `Bearer ${authToken}`,
                };
            }
            const response = await Request.API.request(body);
            return response.data;
        } catch (error: unknown) {
            if (error instanceof Error) {
                throw new Error(error.message);
            } else {
                throw new Error("Unknown error occurred");
            }
        }
    }

    static async get<T>(url: string): Promise<T> {
        return await Request.request("get", url);
    }

    static async post<T, R>(url: string, data: R): Promise<T> {
        return await Request.request("post", url, data);
    }

    static async patch<T, R>(url: string, data: R): Promise<T> {
        return await Request.request("patch", url, data);
    }

    static async delete<T>(url: string): Promise<T> {
        return await Request.request("delete", url);
    }
}
